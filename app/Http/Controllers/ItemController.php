<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ReportReason;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class ItemController extends Controller
{
    private $user;
    private $post;
    private $reportReason;

    public function __construct(Post $post, ReportReason $reportReason, User $user)
    {
        $this->user         = $user;
        $this->post         = $post;
        $this->reportReason = $reportReason;
    }

    public function index()
    {
        $all_report_reasons = $this->reportReason->all();
        $all_user = $this->user->all();

        $wanted_keywords = auth()->user()
            ->wantedItems()
            ->pluck('keyword')
            ->toArray();

        // ページネーションされたデータ取得
        $paginator = $this->post->where('category_id', 3)
            ->latest()
            ->paginate(5);

        // コレクション取得
        $posts = $paginator->getCollection()
            ->map(function ($post) use ($wanted_keywords) {
                $post->is_recommended  = false;
                $post->matched_keyword = null;

                foreach ($wanted_keywords as $keyword) {
                    if (str_contains($post->description, $keyword)) {
                        $post->is_recommended = true;
                        $post->matched_keyword = $keyword;
                        break;
                    }
                }
                return $post;
            })
            ->sortByDesc('is_recommended')
            ->values();

        // ソート済みコレクションを再セットしてページネーターを作成
        $all_posts = new LengthAwarePaginator(
            $posts,
            $paginator->total(),
            $paginator->perPage(),
            $paginator->currentPage(),
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('posts.categories.items.index', compact('all_posts', 'all_report_reasons', 'all_user'));
    }


    public function search(Request $request)
    {
        $all_report_reasons = $this->reportReason->all();

        $posts = $this->post
            ->where('category_id', 3)
            ->where(function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            })
            ->where('user_id', '!=', Auth::id())
            ->latest()->Paginate(5);

        return view('posts.categories.items.search')
            ->with('all_report_reasons', $all_report_reasons)
            ->with('posts', $posts)
            ->with('search', $request->search);
    }
}
