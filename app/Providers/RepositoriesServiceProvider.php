<?php

declare(strict_types=1);

namespace App\Providers;

use App\Categories\Repositories\CategoryRepository;
use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Characters\Repositories\CharacterRepository;
use App\Characters\Repositories\CharacterRepositoryInterface;
use App\ComponentFields\Repositories\ComponentFieldRepository;
use App\ComponentFields\Repositories\ComponentFieldRepositoryInterface;
use App\Components\Repositories\ComponentRepository;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\Games\Repositories\GameRepository;
use App\Games\Repositories\GameRepositoryInterface;
use App\ItemFields\Repositories\ItemFieldRepository;
use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\Items\Repositories\ItemRepository;
use App\Items\Repositories\ItemRepositoryInterface;
use App\LinkedItemFields\Repositories\LinkedItemFieldRepository;
use App\LinkedItemFields\Repositories\LinkedItemFieldRepositoryInterface;
use App\LinkedItems\Repositories\LinkedItemRepository;
use App\LinkedItems\Repositories\LinkedItemRepositoryInterface;
use App\Parameters\Repositories\ParameterRepository;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepository;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\PlayableItems\Repositories\PlayableItemRepository;
use App\PlayableItems\Repositories\PlayableItemRepositoryInterface;
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
