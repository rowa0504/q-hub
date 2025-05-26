<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\ReportReason;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;
use Carbon\Carbon;

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

        $now = Carbon::now();

        // クエリに時間条件を追加
        $paginator = $this->post->where('category_id', 3)
            ->where(function ($query) use ($now) {
                // startdatetimeが今以降 または enddatetimeが今以降
                $query->where('startdatetime', '>=', $now)
                    ->orWhere('enddatetime', '>=', $now);
            })
            ->latest()
            ->paginate(10);

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
        $now = Carbon::now();

        $posts = $this->post
            ->where('category_id', 3)
            ->where(function ($query) use ($request) {
                $query->where('description', 'like', '%' . $request->search . '%');
            })
            ->where(function ($query) use ($now) {
                $query->where('startdatetime', '>=', $now)
                    ->orWhere('enddatetime', '>=', $now);
            })
            ->where('user_id', '!=', Auth::id())
            ->latest()
            ->paginate(10);

        return view('posts.categories.items.search')
            ->with('all_report_reasons', $all_report_reasons)
            ->with('posts', $posts)
            ->with('search', $request->search);
    }
}
