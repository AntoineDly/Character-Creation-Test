<?php

declare(strict_types=1);

namespace App\LinkedItems\Application\Queries\GetLinkedItemsQuery;

use App\LinkedItems\Domain\Dtos\LinkedItemDto\LinkedItemDto;
use App\LinkedItems\Domain\Dtos\LinkedItemDto\LinkedItemDtoCollection;
use App\LinkedItems\Domain\Models\LinkedItem;
use App\LinkedItems\Domain\Services\LinkedItemQueriesService;
use App\LinkedItems\Infrastructure\Repositories\LinkedItemRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetLinkedItemsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<LinkedItem, LinkedItemDto> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private LinkedItemRepositoryInterface $linkedItemRepository,
        private LinkedItemQueriesService $linkedItemQueriesService,
    ) {
    }

    /** @return DtosWithPaginationDto<LinkedItemDto> */
    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetLinkedItemsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetLinkedItemsQuery::class]);
        }
        $linkedItems = $this->linkedItemRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = LinkedItemDtoCollection::fromMap(fn (?LinkedItem $linkedItem) => $this->linkedItemQueriesService->getLinkedItemDtoFromModel(linkedItem: $linkedItem), $linkedItems->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection->getReadonlyCollection(), $linkedItems);
    }
}
