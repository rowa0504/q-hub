<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\TransCategory;
use App\Models\Post;
use App\Models\User;
use App\Models\ReportReason;
use App\Models\Report;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

    private $category;
    private $trans_category;
    private $post;
    private $user;
    private $reportReason;

    public function __construct(Category $category, TransCategory $trans_category, Post $post, User $user, ReportReason $reportReason)
    {
        $this->category = $category;
        $this->trans_category = $trans_category;
        $this->post = $post;
        $this->user = $user;
        $this->reportReason = $reportReason;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $all_categories = $this->category->all();
        $all_trans_categories = $this->trans_category->all();
        $all_posts = $this->post->latest()->get();
        $all_user = $this->user->all();
        $all_report_reasons = $this->reportReason->all();

        return view('home')
            ->with('all_categories', $all_categories)
            ->with('all_trans_categories', $all_trans_categories)
            ->with('all_posts', $all_posts)
            ->with('all_user', $all_user)
            ->with('all_report_reasons', $all_report_reasons);
    }
}
