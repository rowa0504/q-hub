<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class TransportationController extends Controller
{
    public function index()
    {
        $all_posts = Post::where('category_id', 5)->get();

        return view('posts.categories.transportations.index', compact('all_posts'));
    }

    public function show($id)
    {
        return view('posts.categories.transportations.show');
    }
}
