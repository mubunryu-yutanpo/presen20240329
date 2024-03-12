<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'type_id',
        'price',
        'content',
        'thumbnail',
    ];

    // リレーション
    public function users(){
        return $this->belongsTo(User::class);
    }

    public function types(){
        return $this->belongsTo(Type::class);
    }

    public function applies(){
        return $this->hasMany(Apply::class);
    }

    public function public_messages(){
        return $this->hasMany(PublicMessage::class);
    }
}
