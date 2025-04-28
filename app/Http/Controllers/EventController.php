<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class EventController extends Controller
{
    public function index()
    {
        // Eventカテゴリー（category_id = 1）の投稿だけ取得
        $all_posts = Post::where('category_id', 1)->get();

        return view('posts.categories.events.index', compact('all_posts'));
    }

    // public function show($id)
    // {
    //     return view('posts.categories.events.show');
    // }
}
