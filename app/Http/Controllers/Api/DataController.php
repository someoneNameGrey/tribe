<?php

namespace App\Http\Controllers\Api;

use App\Models\Post;
use App\Models\Comment;
use App\Http\Resources\Post as PostResource;
use GuzzleHttp\Client;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DataController extends Controller
{
    const postsEndpoint = 'https://jsonplaceholder.typicode.com/posts';
    const commentsEndpoint = 'https://jsonplaceholder.typicode.com/comments';

    public function fetch()
    {
        $client = new Client();

        //GET posts
        $postRes = $client->request('GET', self::postsEndpoint);
        $posts = json_decode($postRes->getBody());

        foreach ($posts as $post) {
            Post::updateOrCreate(
                [
                    'id' => $post->id
                ],
                [
                    'user_id' => $post->userId,
                    'title'   => $post->title,
                    'body'    => $post->body
                ]
            );
        }

        //GET comments
        $commentRes = $client->request('GET', self::commentsEndpoint);
        $comments = json_decode($commentRes->getBody());

        foreach ($comments as $comment) {
            Comment::updateOrCreate(
                [
                    'id' => $comment->id
                ],
                [
                    'post_id' => $comment->postId,
                    'name'  => $comment->name,
                    'email' => $comment->email,
                    'body'  => $comment->body
                ]
            );
        }

        //orderBy highest engagement scope
        $allPost = Post::highestEngagement()->get();
        return PostResource::collection($allPost);
    }
}
