<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatMessageController extends Controller
{
    // メッセージ送信
    public function store(Request $request, ChatRoom $chatRoom)
    {
        $validated = $request->validate([
            'body' => 'required|string',
        ]);

        $message = new ChatMessage([
            'body' => $validated['body'],
            'user_id' => auth()->id(),
        ]);

        $chatRoom->chatMessages()->save($message);
        return redirect()->route('chatRooms.show', $chatRoom);
    }

    // メッセージ一覧
    public function index(ChatRoom $chatRoom)
    {
        $messages = $chatRoom->chatMessages()->with('user')->get();
        return view('chatRooms.messages', compact('chatRoom', 'messages'));
    }
}
