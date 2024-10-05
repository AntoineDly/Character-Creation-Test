<?php

declare(strict_types=1);

namespace App\Providers;

use App\Shared\Controllers\ApiController\ApiController;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

final class PassportServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Passport::loadKeysFrom(__DIR__.'/../secrets/oauth');
    }
}
