<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\ReportReason;

class EventController extends Controller
{
    private $user;
    private $post;
    private $reportReason;

    public function __construct(User $user, Post $post, ReportReason $reportReason){
        $this->user = $user;
        $this->post = $post;
        $this->reportReason = $reportReason;
    }

    public function index(){
        $all_report_reasons = $this->reportReason->all();
        $all_user = User::all();  // Userモデルを使って全てのユーザーを取得
        $all_posts = Post::where('category_id', 1)->get();  // Eventカテゴリーの投稿を取得

        return view('posts.categories.events.index', compact('all_posts', 'all_user', 'all_report_reasons'));
    }

    public function show($id){
        $all_report_reasons = $this->reportReason->all();
        $all_user = User::all();  // Userモデルを使って全てのユーザーを取得
        $post = $this->post->findOrFail($id);

        return view('posts.categories.events.show')
                ->with('post', $post)
                ->with('all_user', $all_user)
                ->with('all_report_reasons', $all_report_reasons);
    }
}
