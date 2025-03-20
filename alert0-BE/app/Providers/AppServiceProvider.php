<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Events\pendingUser;
use App\Listeners\sendWebUpdate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    protected $listen = [
        pendingUser::class => [
            SendWebSocketUpdate::class,
        ],
    ];
}
