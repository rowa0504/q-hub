<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Answer;
use App\Models\Report;
use App\Models\ChatMessage;
use App\Models\ReportReason;

class AdminController extends Controller
{
    private $user;
    private $post;
    private $comment;
    private $answer;
    private $chatMessage;
    private $report;

    public function __construct(User $user, Post $post, Comment $comment, Answer $answer, ChatMessage $chatMessage, Report $report){
        $this->user = $user;
        $this->post = $post;
        $this->comment = $comment;
        $this->answer = $answer;
        $this->chatMessage = $chatMessage;
        $this->report = $report;
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'user_count'         => User::count(),
            'post_count'         => Post::count(),
            'comments_count'     => Comment::count(),
            'answers_count'      => Answer::count(),
            'reports_count'      => Report::count(),
            'chatMessage_count'  => ChatMessage::count()
        ]);
    }

    // ************ Users ************
    public function users(){
        $all_users = $this->user->withTrashed()->paginate(8);
        return view('admin.users.index', compact('all_users'));
    }

    public function deactivate($id){
        $user = $this->user->findOrFail($id);

        //対象のユーザーの行動を全てsoftdelete
        $user->delete();
        $user->posts()->delete();
        $user->comments()->delete();
        $user->answers()->delete();
        $user->chatMessages()->delete();

        return redirect()->back();
    }

    public function activate($id){
        $user = $this->user->withTrashed()->findOrFail($id);

        //対象のユーザーの行動を全て復元
        $user->restore();
        $user->posts()->withTrashed()->restore();
        $user->comments()->withTrashed()->restore();
        $user->answers()->withTrashed()->restore();
        $user->chatMessages()->withTrashed()->restore();

        return redirect()->back();
    }


    // ************ Posts ************
    public function posts(){
        $all_posts = $this->post->with(['user', 'category'])->withTrashed()->paginate(8);
        return view('admin.posts.index', compact('all_posts'));
    }

    public function deactivatePost($id){
        $this->post->destroy($id);

        return redirect()->back();
    }

    public function activatePost($id){
        $this->post->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }


    // ************ Comments ************
    public function comments(){
        $all_comments = $this->comment->with(['user', 'post'])->withTrashed()->paginate(8);
        return view('admin.comments.index', compact('all_comments'));
    }

    public function deactivateComment($id){
        $this->comment->destroy($id);

        return redirect()->back();
    }

    public function activateComment($id){
        $this->comment->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }


    // ************ Answers ************
    public function answers(){
        $all_answers = $this->answer->with(['user', 'post'])->withTrashed()->paginate(8);
        return view('admin.answers.index', compact('all_answers'));
    }

    public function deactivateAnswer($id){
        $this->answer->destroy($id);

        return redirect()->back();
    }

    public function activateAnswer($id){
        $this->answer->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }


    // ************ ChatMessages ************
    public function chatMessages(){
        $all_chatMessages = $this->chatMessage->with([
            'user' => fn($q) => $q->withTrashed(), // ユーザーが削除されていても取得
            'chatRoom.post' => fn($q) => $q->withTrashed(), // チャットルームに紐づく投稿を取得（削除含む）
        ])
        ->withTrashed() // コメント自体がソフトデリートされていても含める
        ->latest()
        ->paginate(20);

        return view('admin.chatMessage.index', compact('all_chatMessages'));
    }

    public function deactivateChatMessage($id){
        $this->chatMessage->destroy($id);

        return redirect()->back();
    }

    public function activateChatMessage($id){
        $this->chatMessage->onlyTrashed()->findOrFail($id)->restore();

        return redirect()->back();
    }


    // ************ Reports ************
    public function reports(){
        $reports = $this->report->withTrashed()->with([
        'user' => fn($query) => $query->withTrashed(),

        'reportable' => function ($morphTo) {
            $morphTo->morphWith([
                App\Models\Post::class => function ($query) {
                    $query->withTrashed()->with(['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason']);
                },
                App\Models\Comment::class => function ($query) {
                    $query->withTrashed()->with(['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason']);
                },
                App\Models\Answer::class => function ($query) {
                    $query->withTrashed()->with(['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason']);
                },
                App\Models\ChatMessage::class => function ($query) {
                    $query->withTrashed()->with(['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason']);
                },
                App\Models\User::class => function ($query) {
                    $query->withTrashed()->with(['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason']);
                },
            ]);
        },

            'reportReasonReport.reason'
        ])->oldest()->paginate(6);

        $reportedReasons = [];

        foreach ($reports as $report) {
            $reasons = collect();

            foreach ($report->reportReasonReport ?? [] as $reasonReport) {
                if ($reasonReport->reason) {
                    $reasons->push($reasonReport->reason->name);
                }
            }
            $reportedReasons[$report->id] = $reasons;
        }

        return view('admin.reports.index', compact('reports', 'reportedReasons'));
    }

    public function deactivateReport($id){
        $report = $this->report->findOrFail($id);

        $report->status = 'dismissed';
        $report->save();

        $this->report->destroy($id);

        return redirect()->back();
    }

    public function activateReport($id){
        $this->report->onlyTrashed()->findOrFail($id)->restore();

        $report = $this->report->findOrFail($id);

        $report->status = 'pending';
        $report->save();

        return redirect()->back();
    }

    public function reportedUserContent($userId){
        $user = User::withTrashed()->findOrFail($userId);

        $posts = Post::withTrashed()->where('user_id', $user->id)->paginate(8);
        $comments = Comment::withTrashed()->where('user_id', $user->id)->paginate(8);
        $answers = Answer::withTrashed()->where('user_id', $user->id)->paginate(8);
        $chatMessages = ChatMessage::withTrashed()->where('user_id', $user->id)->paginate(8);

        return view('admin.reports.user_content', compact('user', 'posts', 'comments', 'answers', 'chatMessages'));
    }
}
