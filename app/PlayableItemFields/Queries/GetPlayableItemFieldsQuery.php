<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Queries;

use App\PlayableItemFields\Models\PlayableItemField;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\PlayableItemFields\Services\PlayableItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;

final readonly class GetPlayableItemFieldsQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<PlayableItemField> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<PlayableItemField> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private PlayableItemFieldQueriesService $playableItemFieldQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<PlayableItemField> */
    public function get(): DtosWithPaginationDto
    {
        $playableItemFields = $this->playableItemFieldRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?PlayableItemField $playableItemField) => $this->playableItemFieldQueriesService->getPlayableItemFieldDtoFromModel(playableItemField: $playableItemField), $playableItemFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $playableItemFields);
    }
}
