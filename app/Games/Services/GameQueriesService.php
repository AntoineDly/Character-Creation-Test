<?php

declare(strict_types=1);

namespace App\Games\Services;

use App\Categories\Dtos\CategoryDto;
use App\Categories\Services\CategoryQueriesService;
use App\Games\Builders\GameDtoBuilder;
use App\Games\Builders\GameWithCategoriesAndPlayableItemsDtoBuilder;
use App\Games\Dtos\GameDto;
use App\Games\Dtos\GameWithCategoriesAndPlayableItemsDto;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Models\Game;
use App\Helpers\AssertHelper;
use App\PlayableItems\Dtos\PlayableItemDto;
use App\PlayableItems\Services\PlayableItemQueriesService;
use App\Shared\Http\Exceptions\InvalidClassException;
use App\Shared\Http\Exceptions\NotAValidUuidException;
use App\Shared\Http\Exceptions\StringIsEmptyException;
use Illuminate\Database\Eloquent\Model;

final readonly class GameQueriesService
{
    public function __construct(
        private GameDtoBuilder $gameDtoBuilder,
        private GameWithCategoriesAndPlayableItemsDtoBuilder $gameWithCategoriesAndPlayableItemsDtoBuilder,
        private CategoryQueriesService $categoryQueriesService,
        private PlayableItemQueriesService $playableItemQueriesService
    ) {
    }

    /**
     * @throws NotAValidUuidException
     * @throws GameNotFoundException
     * @throws InvalidClassException
     * @throws StringIsEmptyException
     */
    public function getGameDtoFromModel(?Model $game): GameDto
    {
        $game = AssertHelper::isGame($game);

        return $this->gameDtoBuilder
            ->setId(id: $game->id)
            ->setName(name: $game->name)
            ->build();
    }

    public function getGameWithCategoriesAndPlayableItemsDtoFromModel(Game $game): GameWithCategoriesAndPlayableItemsDto
    {
        /** @var CategoryDto[] $categoryDtos */
        $categoryDtos = array_map(fn (?Model $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $game->categories->all());

        /** @var PlayableItemDto[] $playableItemDtos */
        $playableItemDtos = array_map(fn (?Model $playableItem) => $this->playableItemQueriesService->getPlayableItemDtoFromModel(playableItem: $playableItem), $game->playableItems->all());

        return $this->gameWithCategoriesAndPlayableItemsDtoBuilder
            ->setId($game->id)
            ->setName($game->name)
            ->setCategoryDtos($categoryDtos)
            ->setPlayableItemDtos($playableItemDtos)
            ->build();
    }
}
