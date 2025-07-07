<?php

declare(strict_types=1);

namespace App\Games\Queries;

use App\Games\Collection\GameDtoCollection;
use App\Games\Models\Game;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetAllGamesWithoutRequestedCategoryQuery implements QueryInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
        private string $userId,
        private string $categoryId,
    ) {
    }

    public function get(): GameDtoCollection
    {
        $games = $this->gameRepository->getAllGamesWithoutRequestedCategory($this->userId, $this->categoryId);

        return GameDtoCollection::fromMap(fn (Game $game) => $this->gameQueriesService->getGameDtoFromModel(game: $game), $games->all());
    }
}
