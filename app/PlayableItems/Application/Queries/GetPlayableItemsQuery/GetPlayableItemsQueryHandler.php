<?php

declare(strict_types=1);

namespace App\PlayableItems\Application\Queries\GetPlayableItemsQuery;

use App\PlayableItems\Domain\Dtos\PlayableItemDto\PlayableItemDtoCollection;
use App\PlayableItems\Domain\Models\PlayableItem;
use App\PlayableItems\Domain\Services\PlayableItemQueriesService;
use App\PlayableItems\Infrastructure\Repositories\PlayableItemRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetPlayableItemsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<PlayableItem> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private PlayableItemRepositoryInterface $playableItemRepository,
        private PlayableItemQueriesService $playableItemQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetPlayableItemsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetPlayableItemsQuery::class]);
        }
        $playableItems = $this->playableItemRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = PlayableItemDtoCollection::fromMap(fn (?PlayableItem $playableItem) => $this->playableItemQueriesService->getPlayableItemDtoFromModel(playableItem: $playableItem), $playableItems->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection, $playableItems);
    }
}
