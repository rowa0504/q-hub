<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participation;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;

class ParticipationController extends Controller
{
    public function participationToggle($post_id)
    {
        logger('participationToggle called for post_id: ' . $post_id);

        $user_id = Auth::id();
        if (!$user_id) {
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $post = Post::find($post_id);
        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $participation = Participation::where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->first();

        if ($participation) {
            $participation->delete();
            $status = 'unparticipated';
        } else {
            Participation::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
            ]);
            $status = 'participated';
        }

        // 👇 参加者一覧を取得
        $participants = $post->participations()->with('user')->get()->map(function ($p) {
            return [
                'id' => $p->user->id,
                'name' => $p->user->name,
                'avatar' => $p->user->avatar ?? null, // 例：アイコンも送るなら
            ];
        });

        return response()->json([
            'status' => $status,
            'participants_count' => count($participants),
            'participants' => $participants,
        ]);
    }

    public function getParticipants($post_id)
    {
        $post = Post::find($post_id);

        if (!$post) {
            return response()->json(['error' => 'Post not found'], 404);
        }

        $participants = $post->participations()->with('user')->get()->map(function ($p) {
            return [
                'id' => $p->user->id,
                'name' => $p->user->name,
                'avatar' => $p->user->avatar ?? null,
            ];
        });

        return response()->json(['participants' => $participants]);
    }
}
