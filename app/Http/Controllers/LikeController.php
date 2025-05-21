<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Like;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function likeToggle($post_id)
    {
        logger('likeToggle called for post_id: ' . $post_id);

        $user_id = Auth::id();
        if (!$user_id) {
            logger('Auth ID is null!');
            return response()->json(['error' => 'Not authenticated'], 401);
        }

        $post = Post::find($post_id);
        if (!$post) {
            logger('Post not found!');
            return response()->json(['error' => 'Post not found'], 404);
        }

        $like = Like::where('user_id', $user_id)
            ->where('post_id', $post_id)
            ->first();

        if ($like) {
            $like->delete();
            $status = 'unliked';
        } else {
            Like::create([
                'user_id' => $user_id,
                'post_id' => $post_id,
            ]);
            $status = 'liked';
        }

        $likeCount = $post->likes()->count();

        return response()->json([
            'status' => $status,
            'likes_count' => $likeCount,
        ]);
    }

}
