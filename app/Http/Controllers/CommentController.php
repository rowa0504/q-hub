<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    private $comment;

    public function __construct(Comment $comment)
    {
        $this->comment = $comment;
    }

    // コメント投稿
    public function store(Request $request, $post_id)
    {
        $request->validate(
            ['body' => 'required|max:150'],
            [
                'body.required' => 'You cannot submit an empty comment.',
                'body.max'      => 'Your comment must not have more than 150 characters.'
            ]
        );

        $this->comment->body    = $request->input('body');
        $this->comment->user_id = Auth::id();
        $this->comment->post_id = $post_id;
        $this->comment->save();

        return redirect()->route('index', $post_id);
    }

    // コメント削除
    public function destroy($id)
    {
        $this->comment->destroy($id);
        return redirect()->back();
    }

    // コメント編集
    public function update(Request $request, $post_id, $id)
    {
        $request->validate(
            ['body' => 'required|max:150'],
            [
                'body.required' => 'You cannot submit an empty comment.',
                'body.max'      => 'Your comment must not have more than 150 characters.'
            ]
        );

        $comment = $this->comment->findOrFail($id);
        $comment->body    = $request->input('body');
        $comment->user_id = Auth::id();
        $comment->post_id = $post_id;
        $comment->save();

        return redirect()->back();
    }


}
