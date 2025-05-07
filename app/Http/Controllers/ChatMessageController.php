<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ChatMessage;
use Illuminate\Support\Facades\Auth;

class ChatMessageController extends Controller
{
    private $chatMessage;

    public function __construct(ChatMessage $chatMessage){
        $this->chatMessage = $chatMessage;
    }

    public function store(Request $request, $id){
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $this->chatMessage->user_id      = Auth::user()->id;
        $this->chatMessage->chat_room_id = $id;
        $this->chatMessage->body         = $request->body;
        $this->chatMessage->save();

        return redirect()->back();
    }
}
