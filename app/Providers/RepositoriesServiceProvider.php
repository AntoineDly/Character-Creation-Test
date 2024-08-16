<?php

declare(strict_types=1);

namespace App\Providers;

use App\Categories\Repositories\CategoryRepository;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Characters\Repositories\CharacterRepository;
use App\Characters\Repositories\CharacterRepositoryInterface;
use App\Components\Repositories\ComponentRepository;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\DefaultComponentFields\Repositories\DefaultComponentFieldRepository;
use App\DefaultComponentFields\Repositories\DefaultComponentFieldRepositoryInterface;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepository;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepositoryInterface;
use App\Fields\Repositories\FieldRepository;
use App\Fields\Repositories\FieldRepositoryInterface;
use App\Games\Repositories\GameRepository;
use App\Games\Repositories\GameRepositoryInterface;
use App\Items\Repositories\ItemRepository;
use App\Items\Repositories\ItemRepositoryInterface;
use App\LinkedItems\Repositories\LinkedItemRepository;
use App\LinkedItems\Repositories\LinkedItemRepositoryInterface;
use App\Parameters\Repositories\ParameterRepository;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;
use App\Shared\Repositories\AbstractRepository\AbstractRepositoryInterface;
use App\Users\Repositories\UserRepository;
use App\Users\Repositories\UserRepositoryInterface;
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
        $this->app->bind(abstract: DefaultComponentFieldRepositoryInterface::class, concrete: DefaultComponentFieldRepository::class);
        $this->app->bind(abstract: DefaultItemFieldRepositoryInterface::class, concrete: DefaultItemFieldRepository::class);
        $this->app->bind(abstract: FieldRepositoryInterface::class, concrete: FieldRepository::class);
        $this->app->bind(abstract: ItemRepositoryInterface::class, concrete: ItemRepository::class);
        $this->app->bind(abstract: LinkedItemRepositoryInterface::class, concrete: LinkedItemRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
