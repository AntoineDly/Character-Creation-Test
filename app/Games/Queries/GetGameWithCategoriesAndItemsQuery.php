<?php

declare(strict_types=1);

namespace App\Games\Queries;

use App\Games\Dtos\GameWithCategoriesAndItemsDto;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetGameWithCategoriesAndItemsQuery implements QueryInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
        private string $gameId,
    ) {
    }

    public function get(): GameWithCategoriesAndItemsDto
    {
        $game = $this->gameRepository->getGameWithCategoriesAndItemsById(id: $this->gameId);

        return $this->gameQueriesService->getGameWithCategoriesAndItemsDtoFromModel(game: $game);
    }
}
