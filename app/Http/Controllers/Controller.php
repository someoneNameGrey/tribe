<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    const postsEndpoint = 'https://jsonplaceholder.typicode.com/posts';
    const commentsEndpoint = 'https://jsonplaceholder.typicode.com/comments';
    
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
