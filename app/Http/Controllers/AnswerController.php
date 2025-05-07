<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Answer;
use Illuminate\Support\Facades\Auth;

class AnswerController extends Controller
{
    public function store(Request $request){
        $request->validate([
            'body' => 'required|string|max:1000',
            'post_id' => 'required|exists:posts,id',
        ]);

        $answer = new Answer();
        $answer->body = $request->body;
        $answer->post_id = $request->post_id;
        $answer->user_id = Auth::id();
        $answer->save();

        return back()
            ->with('success', 'Answer posted successfully!')
            ->with('open_answer_post_id', $request->post_id);
    }

    public function markBest(Answer $answer){
        $post = $answer->post;

        if (Auth::id() !== $post->user_id) {
            return back()->with('error', 'You are not authorized to select the best answer.');
        }

        // ★ すでにベストアンサーの場合は解除、それ以外はセット
        if ($post->best_answer_id === $answer->id) {
            $post->best_answer_id = null;
        } else {
            $post->best_answer_id = $answer->id;
        }

        $post->save();

        return back()->with('success', 'Best answer updated!')
                     ->with('open_answer_post_id', $post->id);
    }


    public function update(Request $request, $id){
        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        $answer = Answer::findOrFail($id);

        if (Auth::id() !== $answer->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $answer->body = $request->body;
        $answer->save();

        return back()
            ->with('success', 'Answer updated successfully!')
            ->with('open_answer_post_id', $answer->post_id);
    }

    public function destroy($id){
        $answer = Answer::findOrFail($id);

        if (Auth::id() !== $answer->user_id) {
            return back()->with('error', 'Unauthorized action.');
        }

        $answer->delete();

        return back()
            ->with('success', 'Answer deleted successfully.')
            ->with('open_answer_post_id', $answer->post_id);
    }
}
