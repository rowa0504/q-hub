<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ReportReason;
use Illuminate\Support\Facades\Auth;

class FoodController extends Controller
{
    private $post;
    private $reportReason;

    public function __construct(Post $post, ReportReason $reportReason){
        $this->post         = $post;
        $this->reportReason = $reportReason;
    }

    public function index(){
        $all_report_reasons = $this->reportReason->all();
        $all_posts          = $this->post->where('category_id', 2)->latest()->Paginate(10);

        return view('posts.categories.foods.index', compact('all_posts', 'all_report_reasons'));
    }

    public function search(Request $request){
        $all_report_reasons = $this->reportReason->all();

        $posts = $this->post
            ->where('category_id', 2)
            ->where(function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->search . '%')
                    ->orWhere('location', 'like', '%' . $request->search . '%');
            })
            ->where('user_id', '!=', Auth::id())
            ->latest()->paginate(10);

        return view('posts.categories.foods.search')
            ->with('all_report_reasons', $all_report_reasons)
            ->with('posts', $posts)
            ->with('search', $request->search);
    }
}
