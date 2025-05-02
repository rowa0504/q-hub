<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function users()
    {
        $all_users = User::withTrashed()->paginate(10);
        return view('admin.users.index', compact('all_users'));
    }

    public function foods()
    {
        return view('admin.foods.index');
    }

    public function events()
    {
        return view('admin.events.index');
    }

    public function items()
    {
        return view('admin.items.index');
    }

    public function travels()
    {
        return view('admin.travels.index');
    }

    public function transportations()
    {
        return view('admin.transportations.index');
    }

    public function dashboard()
    {
        return view('admin.dashboard', [
            'user_count' => \App\Models\User::count(),
            'post_count' => \App\Models\Post::count(),
            'category_count' => \App\Models\Category::count(),
            'recent_users' => \App\Models\User::latest()->take(5)->get(),
        ]);
    }

    public function deactivate(User $user)
    {
        $user->delete(); // ソフトデリート
        return back()->with('success', "{$user->name} has been deactivated.");
    }

    public function activate($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore(); // ソフトデリート解除
        return back()->with('success', "{$user->name} has been reactivated.");
    }
}
