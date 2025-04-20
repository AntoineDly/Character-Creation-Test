<?php

declare(strict_types=1);

namespace App\PlayableItems\Queries;

use App\PlayableItems\Repositories\PlayableItemRepositoryInterface;
use App\PlayableItems\Services\PlayableItemQueriesService;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class GetPlayableItemsQuery implements QueryInterface
{
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private PlayableItemRepositoryInterface $playableItemRepository,
        private PlayableItemQueriesService $playableItemQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function get(): DtosWithPaginationDto
    {
        $playableItems = $this->playableItemRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Model $playableItem) => $this->playableItemQueriesService->getPlayableItemDtoFromModel(playableItem: $playableItem), $playableItems->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $playableItems);
    }
}
