<?php

declare(strict_types=1);

namespace App\Providers;

use App\Categories\Repositories\CategoryRepository;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Character\Repositories\CharacterRepository;
use App\Character\Repositories\CharacterRepositoryInterface;
use App\Components\Repositories\ComponentRepository;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepository;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepositoryInterface;
use App\Fields\Repositories\FieldRepository;
use App\Fields\Repositories\FieldRepositoryInterface;
use App\Game\Repositories\GameRepository;
use App\Game\Repositories\GameRepositoryInterface;
use App\Parameters\Repositories\ParameterRepository;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;
use App\Shared\Repositories\AbstractRepository\AbstractRepositoryInterface;
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
        $this->app->bind(abstract: CategoryRepositoryInterface::class, concrete: CategoryRepository::class);
        $this->app->bind(abstract: ComponentRepositoryInterface::class, concrete: ComponentRepository::class);
        $this->app->bind(abstract: ParameterRepositoryInterface::class, concrete: ParameterRepository::class);
        $this->app->bind(abstract: DefaultItemFieldRepositoryInterface::class, concrete: DefaultItemFieldRepository::class);
        $this->app->bind(abstract: FieldRepositoryInterface::class, concrete: FieldRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
