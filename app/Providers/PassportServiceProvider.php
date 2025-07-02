<?php

declare(strict_types=1);

namespace App\Providers;

use App\Passport\Repositories\CustomTokenRepository;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;

final class PassportServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(TokenRepository::class, CustomTokenRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::loadKeysFrom(__DIR__.'/../../secrets/oauth');
        Passport::ignoreRoutes();
    }
}
