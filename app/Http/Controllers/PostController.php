<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $page = $request->query('page', 1);

        $posts = \Cache::tags(['posts'])->rememberForever('posts-'.$page, function () {
            return Post::getPaginatedPosts();
        });

        return inertia('Home', [
            'posts' => $posts,
        ]);
    }

    public function show(Request $request, Post $post)
    {
        if (!Gate::allows('view-post', $post)) {
            abort(404);
        }

        $page = $request->query('page', 1);

        $post = \Cache::rememberForever('post-'.$post->id, function () use ($post) {
            return $post;
        });

        $comments = \Cache::tags(['comments'])->rememberForever('comments-'.$page, function () use ($post) {
            return Comment::getPaginatedComments($post);
        });

        return inertia('Post/Show', [
            'post' => $post,
            'comments' => $comments,
        ]);
    }
}
