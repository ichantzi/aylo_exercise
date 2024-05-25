<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\Repositories\PornstarRepositoryInterface;
use App\Repositories\PornstarRepository;
use App\Interfaces\Repositories\PornstarStatsRepositoryInterface;
use App\Repositories\PornstarStatsRepository;
use App\Interfaces\Repositories\AliasRepositoryInterface;
use App\Repositories\AliasRepository;
use App\Interfaces\Repositories\ThumbnailRepositoryInterface;
use App\Repositories\ThumbnailRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(PornstarRepositoryInterface::class, PornstarRepository::class);
        $this->app->bind(PornstarStatsRepositoryInterface::class, PornstarStatsRepository::class);
        $this->app->bind(AliasRepositoryInterface::class, AliasRepository::class);
        $this->app->bind(ThumbnailRepositoryInterface::class, ThumbnailRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
