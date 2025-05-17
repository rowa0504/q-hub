<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ReportReason;

class TravelController extends Controller
{
    private $post;
    private $reportReason;

    public function __construct(Post $post, ReportReason $reportReason){
        $this->post         = $post;
        $this->reportReason = $reportReason;
    }

    public function index()
    {
        $all_report_reasons = $this->reportReason->all();
        $all_posts          = $this->post->where('category_id', 4)->latest()->Paginate(5);

        return view('posts.categories.travels.index', compact('all_posts', 'all_report_reasons'));
    }
}
