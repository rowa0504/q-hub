<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;

class EventController extends Controller
{
    private $user;

    public function __construct(User $user){
        $this->user = $user;
    }

    public function index(){
        $all_user = User::all();  // Userモデルを使って全てのユーザーを取得
        $all_posts = Post::where('category_id', 1)->get();  // Eventカテゴリーの投稿を取得

        return view('posts.categories.events.index', compact('all_posts', 'all_user'));
    }

    // public function show($id)
    // {
    //     return view('posts.categories.events.show');
    // }
}
