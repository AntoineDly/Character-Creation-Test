<?php

declare(strict_types=1);

namespace App\Games\Queries;

use App\Games\Collection\GameDtoCollection;
use App\Games\Repositories\GameRepositoryInterface;
use App\Games\Services\GameQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

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

        return GameDtoCollection::fromMap(fn (?Model $game) => $this->gameQueriesService->getGameDtoFromModel(game: $game), $games->all());
    }
}
