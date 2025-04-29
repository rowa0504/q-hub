<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function index()
    {
        $user = Auth::user();
        $all_posts = Post::where('user_id', Auth::id())->with('user')->latest()->get();

        return view('users.profile.index', compact('user', 'all_posts'));
    }

    public function show($id)
    {
        $user = $this->user->findOrFail($id);
        $all_posts = Post::where('user_id', $user->id)->with('user')->latest()->get();
        return view('users.profile.index', compact('user', 'all_posts'));
    }

    public function edit()
    {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('users.profile.edit')->with('user', $user);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'         => 'required|max:20',
            'email'        => 'required|max:50',
            'introduction' => 'required|min:1|max:1000',
            'avatar'       => 'mimes:jpeg,jpg,png,gif|max:1048'
        ]);

        $user = $this->user->findOrFail($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->introduction = $request->introduction;

        if ($request->avatar) {
            $user->avatar = 'data:image/' . $request->avatar->extension() .
                ';base64,' . base64_encode(file_get_contents($request->avatar));
        }

        $user->save();
        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }
}
