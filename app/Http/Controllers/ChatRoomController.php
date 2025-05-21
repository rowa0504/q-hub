<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\ChatRoom;
use App\Models\ChatMessage;
use App\Models\User;
use App\Models\ReportReason;

class ChatRoomController extends Controller
{
    private $chatRoom;
    private $chatMessage;
    private $post;

    public function __construct(ChatRoom $chatRoom, ChatMessage $chatMessage, Post $post, ReportReason $reportReason){
        $this->chatRoom    = $chatRoom;
        $this->chatMessage = $chatMessage;
        $this->post        = $post;
        $this->reportReason        = $reportReason;
    }

    public function start($post_id){
        //上限を定義するために対象のpostデータを取得
        // $post = $this->post->findOrFail($post_id);

        // // 全てチャットルームがあれば取得、なければ新規作成
        // $chat_room = $this->chatRoom->firstOrCreate(
        //     ['post_id'    => $post_id],
        //     ['created_at' => now(), 'updated_at' => now()]
        // );

        // // 既に参加していなければ参加（user_id + chat_room_id が未登録なら）
        // if (!$chat_room->users()->where('users.id', Auth::id())->exists()) {
        //     // 現在の参加人数を確認
        //     $currentCount = $chat_room->users()->count();

        //     // 上限に達しているか確認
        //     if ($currentCount >= $post->max) {
        //         return redirect()->back()->with('error', 'This chat room is full.');
        //     }

        //     $chat_room->users()->attach(Auth::id(), ['joined_at' => now()]);
        // }

        // // チャットルームにリダイレクト
        // return redirect()->route('chatRoom.show', $chat_room->id);

        $post = $this->post->findOrFail($post_id);

        $chat_room = $this->chatRoom->firstOrCreate(
            ['post_id' => $post_id],
            ['created_at' => now(), 'updated_at' => now()]
        );

        $user = Auth::user();

        // すでに参加済みか確認
        if (!$chat_room->users()->where('users.id', $user->id)->exists()) {

            // 管理者でなければ人数上限を確認
            if ($user->role_id !== 1) {
                $currentCount = $chat_room->users()
                    ->where('role_id', '!=', 1) // 管理者を除外してカウント
                    ->count();

                if ($currentCount >= $post->max) {
                    return redirect()->back()->with('error', 'This chat room is full.');
                }
            }

            // 参加処理（管理者も含めてattach）
            $chat_room->users()->attach($user->id, ['joined_at' => now()]);
        }

        return redirect()->route('chatRoom.show', $chat_room->id);
    }

    public function show($chat_room_id){
        //対象のchatroomをデータを取得
        $chatdate = $this->chatRoom->findOrFail($chat_room_id);

        $all_report_reasons = $this->reportReason->all();

        //対象のchat_room_idのmessageのみ取得
        $all_message = $this->chatMessage
                                ->where('chat_room_id', $chat_room_id)
                                ->orderBy('created_at', 'asc')
                                ->get();

        return view('posts.categories.items.chatroom', compact('chatdate', 'all_message', 'all_report_reasons'));
    }

    public function leave($id){
        // 対象のチャットルームを取得
        $chat_room = $this->chatRoom->findOrFail($id);

        // 認証済みユーザーをチャットルームから削除
        $chat_room->users()->detach(auth()->id());

        return redirect()->route('item.index');
    }
}
