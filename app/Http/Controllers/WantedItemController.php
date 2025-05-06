<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WantedItem;
use Illuminate\Support\Facades\Auth;

class WantedItemController extends Controller
{
    private $wantedItem;

    public function __construct(WantedItem $wantedItem){
        $this->wantedItem = $wantedItem;
    }

    public function store(Request $request){
        $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        $this->wantedItem->user_id = Auth::id();
        $this->wantedItem->keyword = $request->keyword;
        $this->wantedItem->save();

        return redirect()->back()->with('success', 'registered your desired item');
    }
}
