<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ReportReason;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    private $post;
    private $reportReason;

    public function __construct(Post $post, ReportReason $reportReason){
        $this->post = $post;
        $this->reportReason = $reportReason;
    }

    public function index()
    {
        $all_report_reasons = $this->reportReason->all();
        $all_posts = Post::where('category_id', 3)->get();

        return view('posts.categories.items.index', compact('all_posts', 'all_report_reasons'));
    }

    // public function show($id)
    // {
    //     return view('posts.categories.items.show');
    // }

    public function search(Request $request){
        $all_report_reasons = $this->reportReason->all();

        $posts = $this->post
            ->where('category_id', 3)
            ->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            })
            ->where('user_id', '!=', Auth::id())
            ->get();

        return view('posts.categories.items.search')
                ->with('all_report_reasons', $all_report_reasons)
                ->with('posts', $posts)
                ->with('search', $request->search);
    }
}
