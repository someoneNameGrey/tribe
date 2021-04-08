<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable=[
        'id',
        'post_id',
        'name',
        'email',
        'body'
    ];

    //custom primary key and disable incrementing & timestamp of id
    public $incrementing = false;
    public $timestamps = false;

    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}
