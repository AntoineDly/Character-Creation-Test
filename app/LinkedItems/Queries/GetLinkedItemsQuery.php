<?php

declare(strict_types=1);

namespace App\LinkedItems\Queries;

use App\LinkedItems\Repositories\LinkedItemRepositoryInterface;
use App\LinkedItems\Services\LinkedItemQueriesService;
use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Dtos\DtosWithPaginationDto;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Queries\QueryInterface;
use App\Shared\Traits\DtosWithPaginationBuilderHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class GetLinkedItemsQuery implements QueryInterface
{
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private LinkedItemRepositoryInterface $linkedItemRepository,
        private LinkedItemQueriesService $linkedItemQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function get(): DtosWithPaginationDto
    {
        $linkedItems = $this->linkedItemRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Model $linkedItem) => $this->linkedItemQueriesService->getLinkedItemDtoFromModel(linkedItem: $linkedItem), $linkedItems->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $linkedItems);
    }
}
