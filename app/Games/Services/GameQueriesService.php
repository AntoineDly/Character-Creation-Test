<?php

declare(strict_types=1);

namespace App\Games\Services;

use App\Categories\Dtos\CategoryDto;
use App\Categories\Services\CategoryQueriesService;
use App\Games\Builders\GameDtoBuilder;
use App\Games\Builders\GameWithCategoriesAndItemsDtoBuilder;
use App\Games\Dtos\GameDto;
use App\Games\Dtos\GameWithCategoriesAndItemsDto;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Models\Game;
use App\Helpers\AssertHelper;
use App\Items\Dtos\ItemDto;
use App\Items\Services\ItemQueriesService;
use App\Shared\Exceptions\Http\InvalidClassException;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;
use Illuminate\Database\Eloquent\Model;

final readonly class GameQueriesService
{
    public function __construct(
        private GameDtoBuilder $gameDtoBuilder,
        private GameWithCategoriesAndItemsDtoBuilder $gameWithCategoriesAndItemsDtoBuilder,
        private CategoryQueriesService $categoryQueriesService,
        private ItemQueriesService $itemQueriesService
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

    public function getGameWithCategoriesAndItemsDtoFromModel(Game $game): GameWithCategoriesAndItemsDto
    {
        /** @var CategoryDto[] $categoryDtos */
        $categoryDtos = array_map(fn (?Model $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $game->categories->all());

        /** @var ItemDto[] $itemDtos */
        $itemDtos = array_map(fn (?Model $item) => $this->itemQueriesService->getItemDtoFromModel(item: $item), $game->items->all());

        return $this->gameWithCategoriesAndItemsDtoBuilder
            ->setId($game->id)
            ->setName($game->name)
            ->setCategoryDtos($categoryDtos)
            ->setItemDtos($itemDtos)
            ->build();
    }
}
