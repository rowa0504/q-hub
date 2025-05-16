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

    public function users()
    {
        $all_users = $this->user->withTrashed()->paginate(8);
        return view('admin.users.index', compact('all_users'));
    }

    public function posts()
    {
        $all_posts = $this->post->with(['user', 'category'])->withTrashed()->paginate(8);
        return view('admin.posts.index', compact('all_posts'));
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
        $user = $this->user->withTrashed()->findOrFail($id);
        $user->restore(); // ソフトデリート解除

        // 関連する投稿も復元
        $user->posts()->withTrashed()->restore();
        return back()->with('success', "{$user->name} has been reactivated.");
    }

    public function deactivatePost($id)
    {
        $post = $this->post->findOrFail($id);
        $post->delete();

        return back()->with('success', "Post ID {$id} has been deactivated.");
    }

    public function activatePost($id)
    {
        $post = $this->post->withTrashed()->findOrFail($id);
        $post->restore();

        return back()->with('success', "Post ID {$id} has been reactivated.");
    }

    public function comments()
    {
        $all_comments = Comment::with(['user', 'post'])->withTrashed()->paginate(8);
        return view('admin.comments.index', compact('all_comments'));
    }

    public function deactivateComment(Comment $comment)
    {
        $comment->delete();
        return back()->with('success', 'Comment has been deactivated.');
    }

    public function activateComment($id)
    {
        $comment = $this->comment->withTrashed()->findOrFail($id);
        $comment->restore();
        return back()->with('success', 'Comment has been restored.');
    }

    public function answers()
    {
        $all_answers = $this->answer->with(['user', 'post'])->withTrashed()->paginate(8);
        return view('admin.answers.index', compact('all_answers'));
    }

    public function deactivateAnswer(Answer $answer)
    {
        $answer->delete();
        return back()->with('success', 'Answer has been deactivated.');
    }

    public function activateAnswer($id)
    {
        $answer = $this->answer->withTrashed()->findOrFail($id);
        $answer->restore();
        return back()->with('success', 'Answer has been restored.');
    }

    public function chatMessages(){
        $all_chatMessages = ChatMessage::with([
            'user' => fn($q) => $q->withTrashed(), // ユーザーが削除されていても取得
            'chatRoom.post' => fn($q) => $q->withTrashed(), // チャットルームに紐づく投稿を取得（削除含む）
        ])
        ->withTrashed() // コメント自体がソフトデリートされていても含める
        ->latest()
        ->paginate(20);

        return view('admin.chatMessage.index', compact('all_chatMessages'));
    }

    public function deactivateChatMessage($id){
        $chatMessage = $this->chatMessage->withTrashed()->findOrFail($id);

        $chatMessage->delete();

        return back()->with('success', 'Answer has been deactivated.');
    }

    public function activateChatMessage($id){
        $chatMessage = $this->chatMessage->withTrashed()->findOrFail($id);
        $chatMessage->restore();
        return back()->with('success', 'Answer has been restored.');
    }

    public function warnPost(Post $post){
        if ($post->warning_sent) {
            return back()->with('message', 'Warning has already been sent to this post.');
        }

        $post->warning_sent = true;
        $post->save();

        return back()->with('success', "Warning has been sent for post: {$post->title}");
    }

    public function reports(){
        $reports = Report::with([
            'user' => fn($query) => $query->withTrashed(),
            'reportable' => function ($morphTo) {
                $morphTo->morphWith([
                    // 例: 投稿に対する通報
                    App\Models\Post::class => ['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason'],
                    // 他にコメントなどがある場合
                    App\Models\Comment::class => ['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason'],
                    App\Models\Answer::class => ['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason'],
                    App\Models\ChatMessage::class => ['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason'],
                    App\Models\User::class => ['user' => fn($q) => $q->withTrashed(), 'reports.reportReasonReport.reason'],
                ]);
            },
            'reportReasonReport.reason'
        ])->latest()->get();

        $postReportedReasons = [];

        foreach ($reports as $report) {
            $reasons = collect();

            foreach ($report->reportReasonReport ?? [] as $reasonReport) {
                if ($reasonReport->reason) {
                    $reasons->push($reasonReport->reason->name);
                }
            }

            $postReportedReasons[$report->id] = $reasons; // 重複排除しない
        }

        $all_report_reasons = ReportReason::all();

        return view('admin.reports.index', compact('reports', 'postReportedReasons'));
    }

    public function reportSentIndex()
    {
        $warned_posts = $this->post->where('warning_sent', true)->with(['user', 'category'])->get();
        return view('admin.report_sent.index', compact('warned_posts'));
    }


    public function reportedPosts()
    {
        // 通報された投稿だけ取得
        $reportedPosts = Post::whereHas('reports')->with(['user', 'category'])->get();

        return view('admin.reports.reported', compact('reportedPosts'));
    }

    public function reportedUserContent($userId){
        $user = User::withTrashed()->findOrFail($userId);

        $posts = Post::withTrashed()->where('user_id', $user->id)->paginate(8);
        $comments = Comment::withTrashed()->where('user_id', $user->id)->paginate(8);
        $answers = Answer::withTrashed()->where('user_id', $user->id)->paginate(8);
        $chatMessages = ChatMessage::withTrashed()->where('user_id', $user->id)->paginate(8);

        return view('admin.reports.user_content', compact('user', 'posts', 'comments', 'answers', 'chatMessages'));
    }

    public function updateReportMessage(Request $request, $id){
        $report = $this->report->findOrFail($id);

        $report->message = $request->message;
        $report->active = true;
        $report->status = 'warned';
        $report->save();

        return redirect()->back();
    }

    public function deleteReportMessage($id){
        $report = $this->report->findOrFail($id);

        $report->message = null;
        $report->active = true;
        $report->status = 'pending';
        $report->save();

        return redirect()->back();
    }
}
