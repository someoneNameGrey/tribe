<?php

namespace App\Http\Controllers\Api;

use App\Models\Comment;
use App\Http\Resources\Comment as CommentResource;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $params = $request->query();
        $commentsQry = Comment::query();

        if ($params) {
            foreach ($params as $key => $value) {
                $column = $this->decamelize($key);
                //check if the column is existing in our table
                if (Schema::hasColumn('comments', $column)) {
                    $commentsQry->where($column, $value);
                }
            }
        }
        $comments = $commentsQry->get();

        return CommentResource::collection($comments);
    }

    //convert camel cases to snake cases from parameters, to cater to our database structure
    public function decamelize($string) 
    {
        return strtolower(preg_replace(['/([a-z\d])([A-Z])/', '/([^_])([A-Z][a-z])/'], '$1_$2', $string));
    }
}
