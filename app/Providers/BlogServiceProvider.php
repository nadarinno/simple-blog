<?php

namespace App\Providers;

use App\Services\PostContentService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(
            PostContentService::class,
            function (Application $app): PostContentService {
                return new PostContentService(
                    excerptLength: 180,
                    wordsPerMinute: 200
                );
            }
        );
    }

    public function boot(): void
    {
      
    }
}