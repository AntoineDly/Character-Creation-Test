<?php

declare(strict_types=1);

namespace App\Providers;

use App\Categories\Infrastructure\Repositories\CategoryRepository;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Characters\Infrastructure\Repositories\CharacterRepository;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepository;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Components\Infrastructure\Repositories\ComponentRepository;
use App\Components\Infrastructure\Repositories\ComponentRepositoryInterface;
use App\Games\Infrastructure\Repositories\GameRepository;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\ItemFields\Infrastructure\Repositories\ItemFieldRepository;
use App\ItemFields\Infrastructure\Repositories\ItemFieldRepositoryInterface;
use App\Items\Infrastructure\Repositories\ItemRepository;
use App\Items\Infrastructure\Repositories\ItemRepositoryInterface;
use App\LinkedItemFields\Infrastructure\Repositories\LinkedItemFieldRepository;
use App\LinkedItemFields\Infrastructure\Repositories\LinkedItemFieldRepositoryInterface;
use App\LinkedItems\Infrastructure\Repositories\LinkedItemRepository;
use App\LinkedItems\Infrastructure\Repositories\LinkedItemRepositoryInterface;
use App\Parameters\Infrastructure\Repositories\ParameterRepository;
use App\Parameters\Infrastructure\Repositories\ParameterRepositoryInterface;
use App\PlayableItemFields\Infrastructure\Repositories\PlayableItemFieldRepository;
use App\PlayableItemFields\Infrastructure\Repositories\PlayableItemFieldRepositoryInterface;
use App\PlayableItems\Infrastructure\Repositories\PlayableItemRepository;
use App\PlayableItems\Infrastructure\Repositories\PlayableItemRepositoryInterface;
use App\Users\Infrastructure\Repositories\UserRepository;
use App\Users\Infrastructure\Repositories\UserRepositoryInterface;
use Illuminate\Support\ServiceProvider;

final class RepositoriesServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(abstract: CharacterRepositoryInterface::class, concrete: CharacterRepository::class);
        $this->app->bind(abstract: GameRepositoryInterface::class, concrete: GameRepository::class);
        $this->app->bind(abstract: UserRepositoryInterface::class, concrete: UserRepository::class);
        $this->app->bind(abstract: CategoryRepositoryInterface::class, concrete: CategoryRepository::class);
        $this->app->bind(abstract: ParameterRepositoryInterface::class, concrete: ParameterRepository::class);
        $this->app->bind(abstract: ComponentRepositoryInterface::class, concrete: ComponentRepository::class);
        $this->app->bind(abstract: ComponentFieldRepositoryInterface::class, concrete: ComponentFieldRepository::class);
        $this->app->bind(abstract: ItemRepositoryInterface::class, concrete: ItemRepository::class);
        $this->app->bind(abstract: ItemFieldRepositoryInterface::class, concrete: ItemFieldRepository::class);
        $this->app->bind(abstract: PlayableItemRepositoryInterface::class, concrete: PlayableItemRepository::class);
        $this->app->bind(abstract: PlayableItemFieldRepositoryInterface::class, concrete: PlayableItemFieldRepository::class);
        $this->app->bind(abstract: LinkedItemRepositoryInterface::class, concrete: LinkedItemRepository::class);
        $this->app->bind(abstract: LinkedItemFieldRepositoryInterface::class, concrete: LinkedItemFieldRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
