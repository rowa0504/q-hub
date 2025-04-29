<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\ChatRoom;
use App\Models\User;

class ChatRoomController extends Controller
{
    private $chatroom;

    public function __construct(ChatRoom $chatroom){
        $this->chatroom = $chatroom;
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

    public function show($chatRoom)
    {
        $chatdate = $this->chatroom->findOrFail($chatRoom);
        return view('posts.categories.items.chatroom', compact('chatRoom', 'chatdate'));
    }

    // // チャットルーム作成
    // public function store(Request $request, Post $post)
    // {
    //     $chatRoom = $post->chatRoom()->create();

    //     // 投稿者が最初に参加する
    //     $chatRoom->users()->attach(auth()->id(), ['joined_at' => now()]);

    //     return redirect()->route('chatRooms.show', $chatRoom);
    // }

    // // チャットルーム参加
    // public function join(ChatRoom $chatRoom)
    // {
    //     $maxParticipants = $chatRoom->post->max_participants;
    //     $currentParticipants = $chatRoom->users()->count();

    //     if ($currentParticipants >= $maxParticipants) {
    //         return response()->json(['message' => 'このチャットルームは満員です'], 403);
    //     }

    //     $chatRoom->users()->attach(auth()->id(), ['joined_at' => now()]);
    //     return redirect()->route('chatRooms.show', $chatRoom);
    // }

    // // チャットルーム退出
    // public function leave(ChatRoom $chatRoom)
    // {
    //     $chatRoom->users()->detach(auth()->id());
    //     return redirect()->route('chatRooms.index');
    // }
}
