<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PublicMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'project_id',
        'content',
    ];

    // リレーション
    public function users(){
        return $this->belongsTo(User::class);
    }

    public function projects(){
        return $this->belongsTo(Project::class);
    }
}
