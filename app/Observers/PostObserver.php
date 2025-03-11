<?php

namespace App\Observers;

use App\Models\Post;

class PostObserver
{
    public function saving(Post $post)
    {
        \Cache::tags(['posts', 'admin-posts'])->flush();
        \Cache::forget('post-'.$post->id);
    }

    public function deleting(Post $post)
    {
        \Cache::tags(['posts', 'admin-posts'])->flush();
        \Cache::forget('post-'.$post->id);
    }
}
