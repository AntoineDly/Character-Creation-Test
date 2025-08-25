<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetAllGamesWithoutRequestedCategoryQuery;

use App\Games\Domain\Dtos\GameDto\GameDtoCollection;
use App\Games\Domain\Models\Game;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetAllGamesWithoutRequestedCategoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): GameDtoCollection
    {
        if (! $query instanceof GetAllGamesWithoutRequestedCategoryQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetAllGamesWithoutRequestedCategoryQuery::class]);
        }
        $games = $this->gameRepository->getAllGamesWithoutRequestedCategory(userId: $query->userId, categoryId: $query->categoryId);

        return GameDtoCollection::fromMap(fn (Game $game) => $this->gameQueriesService->getGameDtoFromModel(game: $game), $games->all());
    }
}
