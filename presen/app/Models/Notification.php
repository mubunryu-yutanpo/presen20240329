<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiver_id',
        'sender_id',
        'chat_id',
        'read',
        'message',
    ];

    // リレーション
    public function users(){
        return $this->belongsTo(User::class);
    }

    public function chats(){
        return $this->belongsTo(Chat::class);
    }

    public function direct_messages(){
        return $this->belongsTo(DirectMessage::class);
    }
}
