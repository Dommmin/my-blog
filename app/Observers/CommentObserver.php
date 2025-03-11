<?php

namespace App\Observers;

class CommentObserver
{
    public function saving()
    {
        \Cache::tags(['comments'])->flush();
    }

    public function deleting()
    {
        \Cache::tags(['comments'])->flush();
    }
}
