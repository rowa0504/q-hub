<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRoom extends Model
{
    protected $fillable = ['post_id'];

    // このチャットルームの投稿
    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function users(){
        return $this->belongsToMany(User::class)->withPivot('joined_at');
    }

    public function chatMessages(){
        return $this->hasMany(ChatMessage::class);
    }

    public function chatdate(){
        return $this->hasOne(ChatRoom::class); // または hasMany の場合は first() を使う
    }
}
