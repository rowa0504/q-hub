<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ReportReason;

class QuestionController extends Controller
{
    private $post;
    private $reportReason;

    public function __construct(Post $post, ReportReason $reportReason){
        $this->post         = $post;
        $this->reportReason = $reportReason;
    }

    public function index(){
        $all_report_reasons = $this->reportReason->all();
        $all_posts          = $this->post->where('category_id', 6)->latest()->Paginate(5);

        return view('posts.categories.questions.index', compact('all_posts', 'all_report_reasons'));
    }
}
