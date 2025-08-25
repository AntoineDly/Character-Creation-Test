<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetGameWithCategoriesAndPlayableItemsQuery;

use App\Games\Domain\Dtos\GameWithCategoriesAndPlayableItemsDto\GameWithCategoriesAndPlayableItemsDto;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetGameWithCategoriesAndPlayableItemsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): GameWithCategoriesAndPlayableItemsDto
    {
        if (! $query instanceof GetGameWithCategoriesAndPlayableItemsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetGameWithCategoriesAndPlayableItemsQuery::class]);
        }
        $game = $this->gameRepository->getGameWithCategoriesAndPlayableItemsById(id: $query->gameId);

        return $this->gameQueriesService->getGameWithCategoriesAndPlayableItemsDtoFromModel(game: $game);
    }
}
