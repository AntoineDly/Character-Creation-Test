<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Queries\GetComponentFieldsQuery;

use App\ComponentFields\Domain\Models\ComponentField;
use App\ComponentFields\Domain\Services\ComponentFieldQueriesService;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetComponentFieldsQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<ComponentField> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<ComponentField> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ComponentFieldQueriesService $componentFieldQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<ComponentField> */
    public function get(): DtosWithPaginationDto
    {
        $componentFields = $this->componentFieldRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?ComponentField $componentField) => $this->componentFieldQueriesService->getComponentFieldDtoFromModel(componentField: $componentField), $componentFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $componentFields);
    }
}
