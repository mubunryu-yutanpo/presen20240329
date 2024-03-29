<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'sender_id',
        'chat_id',
        'comment',
    ];

    // リレーション
    public function user(){
        return $this->belongsTo(User::class, 'sender_id');
    }

    public function chat(){
        return $this->belongsTo(Chat::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }

}
