<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ChatMessage extends Model
{
    use SoftDeletes;

    protected $fillable = ['chat_room_id', 'user_id', 'body'];

    // メッセージの送信者
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    // 所属するチャットルーム
    public function chatRoom(){
        return $this->belongsTo(ChatRoom::class);
    }

    public function reports(){
        return $this->morphMany(Report::class, 'reportable');
    }
}
