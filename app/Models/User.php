<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, SoftDeletes;

    const ADMIN_ROLE_ID = 1;  // administrator
    const USER_ROLE_ID = 2;   // the regular user

    // 投稿とのリレーション
    public function posts(){
        return $this->hasMany(Post::class);
    }

    // ユーザーが参加しているチャットルーム
    public function chatRooms(){
        return $this->belongsToMany(ChatRoom::class, 'chat_room_user')
            ->withPivot('joined_at', 'left_at')
            ->withTimestamps();
    }

    // ユーザーが送信したメッセージ
    public function chatMessages(){
        return $this->hasMany(ChatMessage::class);
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    // ←← ここの $fillable を1つだけにして、必要な項目をぜんぶ書く！

    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'enrollment_start_date',
        'enrollment_end_date',
        'graduation_status',
    ];

    // パスワードなど見せたくないやつ
    protected $hidden = [
        'password',
        'remember_token',
    ];

    // 自動キャスト設定
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected static function booted(){
        static::deleting(function ($user) {
            if (! $user->isForceDeleting()) {
                $user->posts()->delete(); // ← 論理削除
            }
        });
    }

    public function wantedItems(){
        return $this->hasMany(WantedItem::class);
    }

    public function reports(){
        return $this->morphMany(Report::class, 'reportable');
    }
}
