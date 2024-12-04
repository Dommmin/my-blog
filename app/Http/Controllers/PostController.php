<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        return inertia('Home', [
            'posts' => Post::getPaginatedPosts(),
        ]);
    }

    public function show(Post $post)
    {
        return inertia('Post/Show', [
            'post' => $post,
            'comments' => Comment::getPaginatedComments($post),
        ]);
    }
}
