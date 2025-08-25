<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetGameQuery;

use App\Games\Domain\Dtos\GameDto\GameDto;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetGameQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): GameDto
    {
        if (! $query instanceof GetGameQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetGameQuery::class]);
        }
        $game = $this->gameRepository->findById(id: $query->gameId);

        return $this->gameQueriesService->getGameDtoFromModel(game: $game);
    }
}
