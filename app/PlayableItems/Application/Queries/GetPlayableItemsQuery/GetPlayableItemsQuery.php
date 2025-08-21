<?php

declare(strict_types=1);

namespace App\PlayableItems\Application\Queries\GetPlayableItemsQuery;

use App\PlayableItems\Domain\Models\PlayableItem;
use App\PlayableItems\Domain\Services\PlayableItemQueriesService;
use App\PlayableItems\Infrastructure\Repositories\PlayableItemRepositoryInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;

final readonly class GetPlayableItemsQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<PlayableItem> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<PlayableItem> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private PlayableItemRepositoryInterface $playableItemRepository,
        private PlayableItemQueriesService $playableItemQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<PlayableItem> */
    public function get(): DtosWithPaginationDto
    {
        $playableItems = $this->playableItemRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?PlayableItem $playableItem) => $this->playableItemQueriesService->getPlayableItemDtoFromModel(playableItem: $playableItem), $playableItems->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $playableItems);
    }
}
