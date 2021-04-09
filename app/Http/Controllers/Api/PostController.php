<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class PostController extends Controller
{
    public function index()
    {
        $client = new Client();

        //GET posts
        $postRes = $client->request('GET', static::postsEndpoint);
        $posts = json_decode($postRes->getBody());
        //GET comments
        $commentRes = $client->request('GET', static::commentsEndpoint);
        $comments = json_decode($commentRes->getBody());

        //count the comments and put into array
        $commentsCount = array();
        foreach ($comments as $comment) {
            //if key exist, +1
            if (array_key_exists($comment->postId, $commentsCount)) {
                $commentsCount[$comment->postId] += 1;
            } 
            //else init with 1
            else {
                $commentsCount[$comment->postId] = 1;
            }
        }

        //assigning total comments to post
        $postArr = array();
        foreach ($posts as $post) {
            $newPost = [
                    'post_id'       => $post->id,
                    'post_title'    => $post->title,
                    'post_body'     => $post->body,
                    'total_number_of_comments' => $commentsCount[$post->id]
                ];
            array_push($postArr, $newPost);
        }

        usort($postArr, function($a, $b) {
            return ($a['total_number_of_comments'] <=> $b['total_number_of_comments']) * -1;
        });

        return $postArr;
    }
}
