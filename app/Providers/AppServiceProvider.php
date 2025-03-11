<?php

declare(strict_types=1);

namespace App\Providers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        DB::prohibitDestructiveCommands($this->app->isProduction());
        Model::shouldBeStrict($this->app->environment('local'));
        Model::unguard();
        Vite::prefetch(3);
        Vite::usePrefetchStrategy('aggressive');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        \Gate::define('view-post', function (User $user, Post $post) {
            return $user->isAdmin() || $post->isPublished();
        });
    }
}
