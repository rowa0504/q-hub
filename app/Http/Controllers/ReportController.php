<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function store($postId)
    {
        $post = Post::findOrFail($postId);
        $user = Auth::user();

        // 通報登録（重複登録しないようにsyncWithoutDetaching）
        $user->reportedPosts()->syncWithoutDetaching([$post->id]);

        return back()->with('success', 'Reported successfully!');
    }
}
