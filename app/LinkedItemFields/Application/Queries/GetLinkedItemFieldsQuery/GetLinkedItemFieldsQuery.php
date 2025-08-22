<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Application\Queries\GetLinkedItemFieldsQuery;

use App\LinkedItemFields\Domain\Models\LinkedItemField;
use App\LinkedItemFields\Domain\Services\LinkedItemFieldQueriesService;
use App\LinkedItemFields\Infrastructure\Repositories\LinkedItemFieldRepositoryInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetLinkedItemFieldsQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<LinkedItemField> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<LinkedItemField> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private LinkedItemFieldRepositoryInterface $linkedItemFieldRepository,
        private LinkedItemFieldQueriesService $linkedItemFieldQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<LinkedItemField> */
    public function get(): DtosWithPaginationDto
    {
        $fields = $this->linkedItemFieldRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?LinkedItemField $linkedItemField) => $this->linkedItemFieldQueriesService->getLinkedFieldDtoFromModel(linkedItemField: $linkedItemField), $fields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $fields);
    }
}
