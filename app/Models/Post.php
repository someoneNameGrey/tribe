<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'id',
        'user_id',
        'title',
        'body',
    ];

    //custom primary key and disable incrementing & timestamp of id
    public $incrementing = false;
    public $timestamps = false;

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function scopeHighestEngagement($query)
    {
        return $query->withCount('comments')->orderBy('comments_count', 'DESC');
    }
}
