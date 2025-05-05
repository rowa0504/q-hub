<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class EventController extends Controller
{
    private $user;
    private $post;

    public function __construct(User $user, Post $post){
        $this->user = $user;
        $this->post = $post;
    }

    public function index(){
        $all_user = User::all();  // Userモデルを使って全てのユーザーを取得
        $all_posts = Post::where('category_id', 1)->get();  // Eventカテゴリーの投稿を取得

        return view('posts.categories.events.index', compact('all_posts', 'all_user'));
    }

    public function show($id){
        $all_user = User::all();  // Userモデルを使って全てのユーザーを取得
        $post = $this->post->findOrFail($id);

        return view('posts.categories.events.show')
                ->with('post', $post)
                ->with('all_user', $all_user);
    }
}
