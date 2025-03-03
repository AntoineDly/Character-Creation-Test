<?php

declare(strict_types=1);

namespace App\Games\Queries;

use App\Games\Dtos\GameWithCategoriesAndPlayableItemsDto;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetGameWithCategoriesAndPlayableItemsQuery implements QueryInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
        private string $gameId,
    ) {
    }

    public function get(): GameWithCategoriesAndPlayableItemsDto
    {
        $game = $this->gameRepository->getGameWithCategoriesAndPlayableItemsById(id: $this->gameId);

        return $this->gameQueriesService->getGameWithCategoriesAndPlayableItemsDtoFromModel(game: $game);
    }
}
