<?php

declare(strict_types=1);

namespace App\Games\Domain\Services;

use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Games\Domain\Dtos\GameDto\GameDto;
use App\Games\Domain\Dtos\GameDto\GameDtoBuilder;
use App\Games\Domain\Dtos\GameWithCategoriesAndPlayableItemsDto\GameWithCategoriesAndPlayableItemsDto;
use App\Games\Domain\Dtos\GameWithCategoriesAndPlayableItemsDto\GameWithCategoriesAndPlayableItemsDtoBuilder;
use App\Games\Domain\Models\Game;
use App\Helpers\AssertHelper;
use App\PlayableItems\Domain\Dtos\PlayableItemDto\PlayableItemDtoCollection;
use App\PlayableItems\Domain\Models\PlayableItem;
use App\PlayableItems\Domain\Services\PlayableItemQueriesService;

final readonly class GameQueriesService
{
    public function __construct(
        private CategoryQueriesService $categoryQueriesService,
        private PlayableItemQueriesService $playableItemQueriesService
    ) {
    }

    public function getGameDtoFromModel(?Game $game): GameDto
    {
        $game = AssertHelper::isGameNotNull($game);

        return GameDtoBuilder::create()
            ->setId(id: $game->id)
            ->setName(name: $game->name)
            ->build();
    }

    public function getGameWithCategoriesAndPlayableItemsDtoFromModel(Game $game): GameWithCategoriesAndPlayableItemsDto
    {
        $categoryDtoCollection = CategoryDtoCollection::fromMap(fn (Category $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $game->categories->all());

        $playableItemDtos = PlayableItemDtoCollection::fromMap(fn (PlayableItem $playableItem) => $this->playableItemQueriesService->getPlayableItemDtoFromModel(playableItem: $playableItem), $game->playableItems->all());

        return GameWithCategoriesAndPlayableItemsDtoBuilder::create()
            ->setId($game->id)
            ->setName($game->name)
            ->setCategoryDtoCollection($categoryDtoCollection)
            ->setPlayableItemDtoCollection($playableItemDtos)
            ->build();
    }
}
