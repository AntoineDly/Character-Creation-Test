<?php

declare(strict_types=1);

namespace App\Games\Services;

use App\Categories\Collection\CategoryDtoCollection;
use App\Categories\Models\Category;
use App\Categories\Services\CategoryQueriesService;
use App\Games\Builders\GameDtoBuilder;
use App\Games\Builders\GameWithCategoriesAndPlayableItemsDtoBuilder;
use App\Games\Dtos\GameDto;
use App\Games\Dtos\GameWithCategoriesAndPlayableItemsDto;
use App\Games\Models\Game;
use App\Helpers\AssertHelper;
use App\PlayableItems\Dtos\PlayableItemDto;
use App\PlayableItems\Models\PlayableItem;
use App\PlayableItems\Services\PlayableItemQueriesService;

final readonly class GameQueriesService
{
    public function __construct(
        private GameDtoBuilder $gameDtoBuilder,
        private GameWithCategoriesAndPlayableItemsDtoBuilder $gameWithCategoriesAndPlayableItemsDtoBuilder,
        private CategoryQueriesService $categoryQueriesService,
        private PlayableItemQueriesService $playableItemQueriesService
    ) {
    }

    public function getGameDtoFromModel(?Game $game): GameDto
    {
        $game = AssertHelper::isGameNotNull($game);

        return $this->gameDtoBuilder
            ->setId(id: $game->id)
            ->setName(name: $game->name)
            ->build();
    }

    public function getGameWithCategoriesAndPlayableItemsDtoFromModel(Game $game): GameWithCategoriesAndPlayableItemsDto
    {
        $categoryDtoCollection = CategoryDtoCollection::fromMap(fn (Category $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $game->categories->all());

        /** @var PlayableItemDto[] $playableItemDtos */
        $playableItemDtos = array_map(fn (PlayableItem $playableItem) => $this->playableItemQueriesService->getPlayableItemDtoFromModel(playableItem: $playableItem), $game->playableItems->all());

        return $this->gameWithCategoriesAndPlayableItemsDtoBuilder
            ->setId($game->id)
            ->setName($game->name)
            ->setCategoryDtoCollection($categoryDtoCollection)
            ->setPlayableItemDtos($playableItemDtos)
            ->build();
    }
}
