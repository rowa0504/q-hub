<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participation;
use Illuminate\Support\Facades\Auth;

class ParticipationController extends Controller
{
    private $participation;

    public function __construct(Participation $participation){
        $this->participation = $participation;
    }

    public function store($post_id){
        $this->participation->user_id = Auth::user()->id;
        $this->participation->post_id = $post_id;
        $this->participation->save();

        return redirect()->back();
    }

    public function delete($post_id){
        $this->participation
                ->where('post_id', $post_id)
                ->where('user_id', Auth::user()->id)
                ->delete();

        return redirect()->back();
    }
}
