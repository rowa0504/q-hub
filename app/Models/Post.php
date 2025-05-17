<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;


class Post extends Model
{
    use SoftDeletes;

    public function user(){
        return $this->belongsTo(User::class)->withTrashed();
    }

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function transCategory(){
        return $this->belongsTo(TransCategory::class);
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }

    public function answers(){
        return $this->hasMany(Answer::class);
    }

    public function likes(){
        return $this->hasMany(Like::class);
    }

    public function isLiked(){
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

    public function getCategoryRoute(){
        switch ($this->category_id) {
            case 1:
                return route('event.index', ['id' => $this->id]);
            case 2:
                return route('food.index', ['id' => $this->id]);
            case 3:
                return route('item.index', ['id' => $this->id]);
            case 4:
                return route('travel.index', ['id' => $this->id]);
            case 5:
                return route('transportation.index', ['id' => $this->id]);
            case 6:
                return route('question.index', ['id' => $this->id]);
            default:
                return '#';
        }
    }

    protected $casts = [
        'startdatetime' => 'datetime',
        'enddatetime' => 'datetime',
    ];

    public function participations(){
        return $this->hasMany(Participation::class);
    }

    public function isParticipanted(){
        // check if the user id exists on the likes table and returns boolean
        // value true or false
        return $this->participations()->where('user_id',Auth::user()->id)->exists();
    }

    // 投稿に紐づくチャットルーム
    public function chatRoom(){
        return $this->hasOne(ChatRoom::class);
    }

    // public function reports(){
    //     return $this->hasMany(\App\Models\Report::class);
    // }

    public function reports(){
        return $this->morphMany(Report::class, 'reportable');
    }

    public function images(){
        return $this->hasMany(PostImage::class);
    }
}
