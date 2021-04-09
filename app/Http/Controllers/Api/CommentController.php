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
}
