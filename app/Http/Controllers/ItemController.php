<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ReportReason;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ItemController extends Controller
{
    private $user;
    private $post;
    private $reportReason;

    public function __construct(Post $post, ReportReason $reportReason, User $user){
        $this->user         = $user;
        $this->post         = $post;
        $this->reportReason = $reportReason;
    }

    public function index(){
        $all_report_reasons = $this->reportReason->all();
        $all_user           = $this->user->all();

        $wanted_keywords = auth()->user()
            ->wantedItems()
            ->pluck('keyword')
            ->toArray();

        // 投稿取得 + マッチ判定 + ソート
        $all_posts = $this->post->where('category_id', 3)
            ->get()
            ->map(function ($post) use ($wanted_keywords) {
                $post->is_recommended  = false;
                $post->matched_keyword = null;

                foreach ($wanted_keywords as $keyword) {
                    if (str_contains($post->description, $keyword)) {
                        $post->is_recommended = true;
                        $post->matched_keyword = $keyword;
                        break; // 最初にマッチしたキーワードのみ
                    }
                }

                return $post;
            })
            ->sortByDesc('is_recommended') // おすすめ投稿を上に
            ->values(); // キーをリセット（インデックス0から）

        return view('posts.categories.items.index', compact('all_posts', 'all_report_reasons', 'all_user'));
    }

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
