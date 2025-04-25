<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    private $user;

    public function __construct(User $user,){
        $this->User = $user;
    }
 
    public function show($id){
        $user = $this->user->findOrFail($id);
        return view('profile.show')->with('user',$user);
    }

    public function edit() {
        $user = $this->user->findOrFail(Auth::user()->id);
        return view('profile.show')->with('user',$user);
    }

    public function update(Request $request, $id){
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
    
        if ($request->avatar){
            $user->avatar = 'data:image/' . $request->avatar->extension() .
            ';base64,'. base64_encode(file_get_contents($request->avatar));
        }
    
        $user->save();
        return redirect()->back();
    }
    
    
}
