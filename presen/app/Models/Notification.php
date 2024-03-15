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
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function chat(){
        return $this->belongsTo(Chat::class);
    }

    public function direct_message(){
        return $this->belongsTo(DirectMessage::class);
    }
}
