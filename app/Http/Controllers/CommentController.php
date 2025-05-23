<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;
use App\Models\ReportReason;


class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }
    // コメント投稿
    public function store(Request $request, $postId)
    {
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        $comment = new Comment();
        $comment->post_id = $postId;
        $comment->user_id = Auth::id();
        $comment->body = $request->body;
        $comment->save();

        $comment->load('user');

        $all_report_reasons = ReportReason::all(); // ← ここでまとめて取得

        $html = view('posts.components.partials.comment_card', [
            'comment' => $comment,
            'all_report_reasons' => $all_report_reasons,
        ])->render();

        $modal = view('posts.components.partials.comment_report_modal', [
            'comment' => $comment,
            'all_report_reasons' => $all_report_reasons,
        ])->render();

        return response()->json([
            'html' => $html,
            'modal' => $modal,
        ]);
    }


    // コメント編集
    public function update(Request $request, $post_id, $id)
    {
        $request->validate([
            'body' => 'required|string|max:255',
        ]);

        // コメントを取得（IDで検索）
        $comment = Comment::findOrFail($id);

        // 投稿IDが一致するかチェック（安全のため）
        if ($comment->post_id != $post_id) {
            return response()->json(['message' => 'Invalid post ID'], 400);
        }

        // ログインユーザーが投稿者かどうかも確認したほうが安全です
        if ($comment->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->body = $request->body;
        $comment->save();

        return response()->json([
            'id' => $comment->id,
            'body' => $comment->body,
        ]);
    }

    public function destroy($id)
    {
        $comment = Comment::findOrFail($id);

        if ($comment->user_id != Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Deleted successfully']);
    }
}
