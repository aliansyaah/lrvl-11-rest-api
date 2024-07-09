<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        // Get all posts
        $posts = Post::latest()->paginate(5);

        // Return collection of post as a resource
        return new PostResource(true, 'List data post', $posts);
    }
}
