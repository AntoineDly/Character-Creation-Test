<?php

declare(strict_types=1);

namespace App\Providers;

use App\Shared\Controllers\ApiController\ApiController;
use App\Shared\Controllers\ApiController\ApiControllerInterface;
use Illuminate\Support\ServiceProvider;

final class ControllersServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(abstract: ApiControllerInterface::class, concrete: ApiController::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
