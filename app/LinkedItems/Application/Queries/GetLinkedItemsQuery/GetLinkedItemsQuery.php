<?php

declare(strict_types=1);

namespace App\LinkedItems\Application\Queries\GetLinkedItemsQuery;

use App\LinkedItems\Domain\Models\LinkedItem;
use App\LinkedItems\Domain\Services\LinkedItemQueriesService;
use App\LinkedItems\Infrastructure\Repositories\LinkedItemRepositoryInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetLinkedItemsQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<LinkedItem> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<LinkedItem> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private LinkedItemRepositoryInterface $linkedItemRepository,
        private LinkedItemQueriesService $linkedItemQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<LinkedItem> */
    public function get(): DtosWithPaginationDto
    {
        $linkedItems = $this->linkedItemRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?LinkedItem $linkedItem) => $this->linkedItemQueriesService->getLinkedItemDtoFromModel(linkedItem: $linkedItem), $linkedItems->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $linkedItems);
    }
}
