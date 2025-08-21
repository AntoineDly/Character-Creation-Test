<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetAllGamesWithoutRequestedCategoryQuery;

use App\Games\Domain\Collection\GameDtoCollection;
use App\Games\Domain\Models\Game;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
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
