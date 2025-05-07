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
    private $post;

    public function __construct(ChatRoom $chatroom, ChatMessage $chatMessage, Post $post){
        $this->chatroom = $chatroom;
        $this->chatMessage = $chatMessage;
        $this->post = $post;
    }

    public function start($post_id){
        $post = $this->post->findOrFail($post_id);

        // 全てチャットルームがあれば取得、なければ新規作成
        $chatRoom = ChatRoom::firstOrCreate(
            ['post_id' => $post_id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        // 既に参加していなければ参加（user_id + chat_room_id が未登録なら）
        if (!$chatRoom->users()->where('users.id', Auth::id())->exists()) {
            // 現在の参加人数を確認
            $currentCount = $chatRoom->users()->count();

            // 上限に達しているか確認
            if ($currentCount >= $post->max) {
                return redirect()->back()->with('error', 'This chat room is full.');
            }

            $chatRoom->users()->attach(Auth::id(), ['joined_at' => now()]);
        }

        // チャットルームにリダイレクト
        return redirect()->route('chatRoom.show', $chatRoom->id);
    }

    public function show($chatRoom){
        $chatdate = $this->chatroom->findOrFail($chatRoom);
        $all_message = $this->chatMessage
        ->where('chat_room_id', $chatRoom)
        ->orderBy('created_at', 'asc')
        ->get();

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
