<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetAllGamesQuery;

use App\Games\Domain\Dtos\GameDto\GameDtoCollection;
use App\Games\Domain\Models\Game;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GeAllGamesQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): GameDtoCollection
    {
        if (! $query instanceof GetAllGamesQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetAllGamesQuery::class]);
        }
        $games = $this->gameRepository->all($query->userId);

        return GameDtoCollection::fromMap(fn (Game $game) => $this->gameQueriesService->getGameDtoFromModel(game: $game), $games->all());
    }
}
