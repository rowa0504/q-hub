<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function transCategory()
    {
        return $this->belongsTo(TransCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function isLiked()
    {
        return $this->likes()->where('user_id', Auth::user()->id)->exists();
    }

    public function getCategoryRoute()
    {
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
                return route('questions.index', ['id' => $this->id]);
            default:
                return '#';
        }
    }

    public function reports()
{
    return $this->belongsToMany(User::class, 'post_user_reports')->withTimestamps();
}

}
