<?php

declare(strict_types=1);

namespace App\PlayableItems\Application\Queries\GetPlayableItemQuery;

use App\PlayableItems\Domain\Dtos\PlayableItemDto\PlayableItemDto;
use App\PlayableItems\Domain\Services\PlayableItemQueriesService;
use App\PlayableItems\Infrastructure\Repositories\PlayableItemRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetPlayableItemQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PlayableItemRepositoryInterface $playableItemRepository,
        private PlayableItemQueriesService $playableItemQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): PlayableItemDto
    {
        if (! $query instanceof GetPlayableItemQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetPlayableItemQuery::class]);
        }
        $playableItem = $this->playableItemRepository->findById(id: $query->playableItemId);

        return $this->playableItemQueriesService->getPlayableItemDtoFromModel(playableItem: $playableItem);
    }
}
