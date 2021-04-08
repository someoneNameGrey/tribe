<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Http\Resources\Post as PostResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index()
    {
        //orderBy highest engagement scope
        $allPost = Post::highestEngagement()->get();
        return PostResource::collection($allPost);
    }
}
