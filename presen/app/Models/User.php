<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail; // 2段階認証（メール確認）を有効化
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

//class User extends Authenticatable
//{
//    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'introduction',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    // リレーション
    public function projects(){
        return $this->hasMany(Project::class);
    }

    public function applies(){
        return $this->hasMany(Apply::class);
    }

    public function public_messages(){
        return $this->hasMany(PublicMessage::class);
    }

    public function direct_messages(){
        return $this->hasMany(DirectMessage::class);
    }

    public function notifications(){
        return $this->hasMany(Notification::class);
    }
}
