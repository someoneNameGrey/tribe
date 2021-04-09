<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use GuzzleHttp\Client;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $client = new Client();
        //GET comments
        $commentRes = $client->request('GET', static::commentsEndpoint);
        $comments = json_decode($commentRes->getBody());

        $commentArr = array();

        if ($request->query('q')) {
            $terms = $request->query('q');
            foreach ($comments as $comment) {
                $objVar = get_object_vars($comment);
                foreach ($objVar as $key => $value) {
                    if (strpos($value, $terms) !== false )  {
                        array_push($commentArr, $comment);
                        break;
                    }
                }
            }
            return $commentArr;
        }
        return $comments;
    }

    public function advFilter(Request $request)
    {
        $client = new Client();
        //GET posts
        $postRes = $client->request('GET', static::postsEndpoint);
        $posts = json_decode($postRes->getBody());
        //GET comments
        $commentRes = $client->request('GET', static::commentsEndpoint);
        $comments = json_decode($commentRes->getBody());

        $commentsArr = array();
        foreach ($comments as $comment) {
            if (!array_key_exists($comment->postId, $commentsArr)) {
                $commentsArr[$comment->postId] = array();
            } 
            array_push($commentsArr[$comment->postId], $comment);
        }

        foreach ($posts as $post) {
            $post->comments = $commentsArr[$post->id];
        }

        if ($request->query('q')) {
            $resultPosts = array();
            $terms = $request->query('q');

            foreach ($posts as $post) {
                $postObjVar = get_object_vars($post);
                foreach ($postObjVar as $postKey => $value) {
                    //excluding comments field in this search
                    if ($postKey != 'comments') {
                        if (strpos($value, $terms) !== false )  {
                            array_push($resultPosts, $post);
                            break;
                        }
                    }
                    //if there's no matching words in post, then go for comments
                    else {
                        foreach ($post->comments as $comment) {
                            $objVar = get_object_vars($comment);
                            foreach ($objVar as $key => $value) {
                                if (strpos($value, $terms) !== false )  {
                                    array_push($resultPosts, $post);
                                    break;
                                }
                            }
                        }
                    }
                }
            }
            return $resultPosts;
        }
        return $posts;
    }
}
