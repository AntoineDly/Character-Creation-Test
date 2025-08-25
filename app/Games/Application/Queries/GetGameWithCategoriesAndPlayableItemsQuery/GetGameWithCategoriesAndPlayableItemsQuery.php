<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetGameWithCategoriesAndPlayableItemsQuery;

use App\Games\Domain\Dtos\GameWithCategoriesAndPlayableItemsDto\GameWithCategoriesAndPlayableItemsDto;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetGameWithCategoriesAndPlayableItemsQuery implements QueryInterface
{
    public function __construct(
        public string $gameId,
    ) {
    }

    public function get(): GameWithCategoriesAndPlayableItemsDto
    {
        $game = $this->gameRepository->getGameWithCategoriesAndPlayableItemsById(id: $this->gameId);

        return $this->gameQueriesService->getGameWithCategoriesAndPlayableItemsDtoFromModel(game: $game);
    }
}
