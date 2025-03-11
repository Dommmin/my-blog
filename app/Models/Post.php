<?php

declare(strict_types=1);

namespace App\Models;

use App\Observers\PostObserver;
use Carbon\Carbon;
use Carbon\Month;
use Carbon\WeekDay;
use DateTimeInterface;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

#[ObservedBy([PostObserver::class])]
class Post extends Model
{
    use HasFactory;
    use HasSlug;
    use SoftDeletes;

    protected $guarded = [];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comment::class);
    }

    public function getCreatedAtAttribute(DateTimeInterface|WeekDay|Month|string|int|float|null $value): string
    {
        return Carbon::parse($value)->diffForHumans();
    }

    public function getImageAttribute($value): string
    {
        return Storage::url($value);
    }

    public static function getPaginatedPosts(): LengthAwarePaginator
    {
        return self::query()
            ->where('published', true)
            ->latest('created_at')
            ->paginate(6)
            ->onEachSide(1);
    }

    public static function getPaginatedPostsForAdmin(array $filters = []): LengthAwarePaginator
    {
        $query = self::query()
            ->with('user')
            ->when(isset($filters['search']), function ($query, $search) {
                return $query->where(function ($q) use ($search): void {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search): void {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                });
            });

        $sort = $filters['sort'] ?? 'created_at';
        $direction = $filters['direction'] ?? 'desc';

        $allowedSorts = ['title', 'created_at', 'status'];
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'created_at';

        $query->orderBy($sort, $direction);

        return $query
            ->paginate(10)
            ->onEachSide(1)
            ->withQueryString();
    }

    public function isPublished()
    {
        return $this->published;
    }
}
