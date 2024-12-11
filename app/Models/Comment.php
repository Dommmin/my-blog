<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;

class Comment extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $guarded = [];

    protected $appends = [
        'is_modified',
        'created_at_formatted',
        'updated_at_formatted',
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getIsModifiedAttribute(): bool
    {
        return Carbon::parse($this->updated_at)->ne(Carbon::parse($this->created_at));
    }

    public function getCreatedAtFormattedAttribute(): string
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getUpdatedAtFormattedAttribute(): string
    {
        return Carbon::parse($this->updated_at)->diffForHumans();
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
