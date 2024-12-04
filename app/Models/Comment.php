<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function getPaginatedComments(Post $post): LengthAwarePaginator
    {
        return self::query()
            ->where('post_id', $post->id)
            ->with('user')
            ->latest('created_at')
            ->paginate(10)
            ->onEachSide(1);
    }
}
