<?php

declare(strict_types=1);

namespace App\Items\Application\Queries\GetItemsQuery;

use App\Items\Domain\Dtos\ItemDto\ItemDtoCollection;
use App\Items\Domain\Models\Item;
use App\Items\Domain\Services\ItemQueriesService;
use App\Items\Infrastructure\Repositories\ItemRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;

final readonly class GetItemsQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<Item> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Item> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
        private ItemQueriesService $itemQueriesService,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetItemsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetItemsQuery::class]);
        }
        $items = $this->itemRepository->index($query->sortedAndPaginatedDto);

        $dtos = ItemDtoCollection::fromMap(fn (?Item $item) => $this->itemQueriesService->getItemDtoFromModel(item: $item), $items->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $items);
    }
}
