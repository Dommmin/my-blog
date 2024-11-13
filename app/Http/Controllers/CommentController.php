<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Http\Requests\CommentUpdateRequest;
use App\Models\Comment;
use App\Models\Post;

class CommentController extends Controller
{
    public function store(Post $post, CommentStoreRequest $request)
    {
        Comment::create($request->validated() + [
            'user_id' => auth()->id(),
            'post_id' => $post->id,
        ]);

        return to_route('post.show', $post->slug)->with('success', 'Comment posted successfully');
    }

    public function update(Comment $comment, CommentUpdateRequest $request)
    {
        $comment->update($request->validated());

        return back()->with('success', 'Comment updated successfully');
    }

    public function destroy(Comment $comment)
    {
        $comment->delete();

        return back()->with('success', 'Comment deleted successfully');
    }
}
