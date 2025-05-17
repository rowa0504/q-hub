<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;


class Answer extends Model
{
    use SoftDeletes;
    use HasFactory;

    protected $fillable = [
        'body', 'user_id', 'post_id',
    ];

    // Answerが持つUser（回答者）
    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    // App\Models\Answer.php
    public function post(){
        return $this->belongsTo(Post::class);
    }

    public function reports(){
        return $this->morphMany(Report::class, 'reportable');
    }
}
