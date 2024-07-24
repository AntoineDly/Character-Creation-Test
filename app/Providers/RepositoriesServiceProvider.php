<?php

declare(strict_types=1);

namespace App\Providers;

use App\Base\Repositories\AbstractRepository\AbstractRepository;
use App\Base\Repositories\AbstractRepository\AbstractRepositoryInterface;
use App\Character\Repositories\CharacterRepository;
use App\Character\Repositories\CharacterRepositoryInterface;
use App\Game\Repositories\GameRepository;
use App\Game\Repositories\GameRepositoryInterface;
use App\User\Repositories\UserRepository;
use App\User\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(abstract: AbstractRepositoryInterface::class, concrete: AbstractRepository::class);
        $this->app->bind(abstract: CharacterRepositoryInterface::class, concrete: CharacterRepository::class);
        $this->app->bind(abstract: GameRepositoryInterface::class, concrete: GameRepository::class);
        $this->app->bind(abstract: UserRepositoryInterface::class, concrete: UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
