<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    use HasFactory;

    protected $fillable = [
        'user1_id',
        'user2_id',
    ];

    // リレーション
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function direct_messages(){
        return $this->hasMany(DirectMessage::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }
}
