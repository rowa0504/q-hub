<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\ReportReason;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    private $user;
    private $post;
    private $reportReason;

    public function __construct(User $user, Post $post, ReportReason $reportReason){
        $this->user         = $user;
        $this->post         = $post;
        $this->reportReason = $reportReason;
    }

    public function index(){
        $all_report_reasons = $this->reportReason->all();
        $all_user           = $this->user->all();
        $all_posts          = $this->post->where('category_id', 1)->latest()->Paginate(10);

        return view('posts.categories.events.index', compact('all_posts', 'all_user', 'all_report_reasons'));
    }

    public function show($id){
        $all_report_reasons = $this->reportReason->all();
        $all_user           = $this->user->all();
        $post               = $this->post->findOrFail($id);

        return view('posts.categories.events.show', compact('post', 'all_user', 'all_report_reasons'));
    }

    public function search(Request $request){
        $all_report_reasons = $this->reportReason->all();
        $all_user           = $this->user->all();

        $posts = $this->post
            ->where('category_id', 1)
            ->where(function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->search . '%');
            })
            ->where('user_id', '!=', Auth::id())
            ->latest()->paginate(10); // ← Pは小文字の `paginate`

        return view('posts.categories.events.search')
            ->with('all_report_reasons', $all_report_reasons)
            ->with('posts', $posts)
            ->with('all_user', $all_user)
            ->with('search', $request->search);
    }
}
