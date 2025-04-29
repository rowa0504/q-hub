<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $fillable = [
        'body', 'user_id', 'post_id',
    ];

    // Answerが持つUser（回答者）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // App\Models\Answer.php
public function post()
{
    return $this->belongsTo(Post::class);
}
}
