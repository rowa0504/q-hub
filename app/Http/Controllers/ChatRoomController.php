<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;

class ChatRoomController extends Controller
{
    private $chatroom;
    private $chatMessage;

    public function __construct(ChatRoom $chatroom, ChatMessage $chatMessage){
        $this->chatroom = $chatroom;
        $this->chatMessage = $chatMessage;
    }

    public function start($post_id){
        // 全てチャットルームがあれば取得、なければ新規作成
        $chatRoom = ChatRoom::firstOrCreate(
            ['post_id' => $post_id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // 既に参加していなければ参加（user_id + chat_room_id が未登録なら）
        if (!$chatRoom->users()->where('users.id', Auth::id())->exists()) {
            $chatRoom->users()->attach(Auth::id(), ['joined_at' => now()]);
        }

        // チャットルームにリダイレクト
        return redirect()->route('chatRoom.show', $chatRoom->id);
    }

    public function show($chatRoom){
        $chatdate = $this->chatroom->findOrFail($chatRoom);
        $all_message = $this->chatMessage->latest()->get();

        return view('posts.categories.items.chatroom', compact('chatRoom', 'chatdate', 'all_message'));
    }

    // チャットルーム退出
    public function leave($id){
        // 対象のチャットルームを取得
        $chatRoom = ChatRoom::findOrFail($id);

        // 認証済みユーザーをチャットルームから削除
        $chatRoom->users()->detach(auth()->id());

        return redirect()->route('item.index')->with('status', 'チャットルームから退出しました');
    }
}
