<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetAllGamesQuery;

use App\Games\Domain\Dtos\GameDto\GameDtoCollection;
use App\Games\Domain\Models\Game;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Queries\QueryInterface;

final readonly class GetAllGamesQuery implements QueryInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
        private string $userId
    ) {
    }

    public function get(): GameDtoCollection
    {
        $games = $this->gameRepository->all($this->userId);

        return GameDtoCollection::fromMap(fn (Game $game) => $this->gameQueriesService->getGameDtoFromModel(game: $game), $games->all());
    }
}
