<?php

declare(strict_types=1);

namespace App\Items\Queries;

use App\Items\Models\Item;
use App\Items\Repositories\ItemRepositoryInterface;
use App\Items\Services\ItemQueriesService;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;

final readonly class GetItemsQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<Item> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Item> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
        private ItemQueriesService $itemQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<Item> */
    public function get(): DtosWithPaginationDto
    {
        $items = $this->itemRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Item $item) => $this->itemQueriesService->getItemDtoFromModel(item: $item), $items->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $items);
    }
}
