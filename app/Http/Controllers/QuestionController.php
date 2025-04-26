<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class QuestionController extends Controller
{
    public function index()
    {
        $all_posts = Post::where('category_id', 6)->get();

        return view('posts.categories.events.index', compact('all_posts'));
    }

    public function show($id)
    {
        return view('posts.categories.questions.show');
    }
}
