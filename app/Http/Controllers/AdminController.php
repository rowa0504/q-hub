<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Answer;

class AdminController extends Controller
{
    private $user;
    private $post;
    private $comment;
    private $answer;

    public function __construct(User $user, Post $post, Comment $comment, Answer $answer){
        $this->user = $user;
        $this->post = $post;
        $this->comments = $comment;
        $this->answer = $answer;
    }

    public function users(){
        $all_users = $this->user->withTrashed()->paginate(10);
        return view('admin.users.index', compact('all_users'));
    }

    public function posts()
    {
        $all_posts = Post::with(['user', 'category'])->withTrashed()->paginate(10);
        return view('admin.posts.index', compact('all_posts'));
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
// AdminController.php

public function warnPost(\App\Models\Post $post)
{
    if ($post->warning_sent) {
        return back()->with('message', 'Warning has already been sent to this post.');
    }

    $post->warning_sent = true;
    $post->save();

    return back()->with('success', "Warning has been sent for post: {$post->title}");
}


    public function reports()
    {
        $reports = \App\Models\Report::with([
            'user' => fn($query) => $query->withTrashed(),
            'post' => fn($query) => $query->withTrashed()->with(['user' => fn($q) => $q->withTrashed()]),
            'reportReasonReport.reason'
        ])->latest()->get();

        return view('admin.reports.index', compact('reports'));
    }
}
