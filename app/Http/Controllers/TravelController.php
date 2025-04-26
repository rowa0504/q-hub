<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class TravelController extends Controller
{
    public function index()
    {
        $all_posts = Post::where('category_id', 4)->get();

        return view('posts.categories.events.index', compact('all_posts'));
    }

    public function show($id)
    {
        return view('posts.categories.travels.show');
    }
}
