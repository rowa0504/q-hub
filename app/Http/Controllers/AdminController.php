<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Answer;

class AdminController extends Controller
{
    public function users()
    {
        $all_users = User::withTrashed()->paginate(10);
        return view('admin.users.index', compact('all_users'));
    }

    public function posts()
    {
        $all_posts = Post::with(['user', 'category'])->withTrashed()->paginate(10);
        return view('admin.posts.index', compact('all_posts'));
    }

    public function foods()
    {
        return view('admin.foods.index');
    }

    public function events()
    {
        return view('admin.events.index');
    }

    public function items()
    {
        return view('admin.items.index');
    }

    public function travels()
    {
        return view('admin.travels.index');
    }

    public function transportations()
    {
        return view('admin.transportations.index');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'user_count' => \App\Models\User::count(),
            'post_count' => \App\Models\Post::count(),
            'comments_count' => \App\Models\Comment::count(),
            'recent_users' => \App\Models\User::latest()->take(5)->get(),
        ]);
    }

    public function deactivate(User $user)
    {
        // 投稿も論理削除
        $user->posts()->delete(); // ←★これを追加！

        // ユーザーをソフトデリート
        $user->delete();

        return back()->with('success', "{$user->name} has been deactivated along with their posts.");
    }



    public function activate($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore(); // ソフトデリート解除

        // 関連する投稿も復元
        $user->posts()->withTrashed()->restore();
        return back()->with('success', "{$user->name} has been reactivated.");
    }

    public function deactivatePost($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return back()->with('success', "Post ID {$id} has been deactivated.");
    }

    public function activatePost($id)
    {
        $post = Post::withTrashed()->findOrFail($id);
        $post->restore();

        return back()->with('success', "Post ID {$id} has been reactivated.");
    }

    public function comments()
    {
        $all_comments = Comment::with(['user', 'post'])->withTrashed()->paginate(10);
        return view('admin.comments.index', compact('all_comments'));
    }

    public function deactivateComment(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment has been deactivated.');
    }

    public function activateComment($id)
    {
        $comment = Comment::withTrashed()->findOrFail($id);
        $comment->restore();
        return back()->with('success', 'Comment has been restored.');
    }

    public function answers()
    {
        $all_answers = Answer::with(['user', 'post'])->withTrashed()->paginate(10);
        return view('admin.answers.index', compact('all_answers'));
    }

    public function deactivateAnswer(Answer $answer)
    {
        $answer->delete();
        return back()->with('success', 'Answer has been deactivated.');
    }

    public function activateAnswer($id)
    {
        $answer = Answer::withTrashed()->findOrFail($id);
        $answer->restore();
        return back()->with('success', 'Answer has been restored.');
    }

    // 警告送信
    public function warn(User $user)
    {
        if ($user->warning_sent) {
            return back()->with('message', 'Warning has already been sent.');
        }

        $user->warning_sent = true;
        $user->save();

        return back()->with('success', "{$user->name} has been warned.");
    }


    public function reports()
    {
        $reports = \App\Models\Report::with(['user', 'post.user', 'reportReasonReport.reason'])->latest()->get();
        return view('admin.reports.index', compact('reports'));
    }
}
