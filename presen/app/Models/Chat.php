<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user1_id',
        'user2_id',
    ];

    // 最新のメッセージを取得するアクセサ
    public function getLatestMessageAttribute()
    {
        return $this->direct_messages()->latest()->first();
    }

    // 最新のメッセージの投稿者を取得するアクセサ
    public function getLatestMessageUserAttribute()
    {
        return $this->latestMessage ? $this->latestMessage->user : null;
    }

    // チャット内に未読メッセージがあるか判定
    public function hasUnreadMessages()
    {
        return $this->notifications()
            ->where('receiver_id', Auth::id())
            ->where('read', false)
            ->exists();
    }


    // リレーション
// Chatモデル
    public function user1()
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2()
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function direct_messages(){
        return $this->hasMany(DirectMessage::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }
}
