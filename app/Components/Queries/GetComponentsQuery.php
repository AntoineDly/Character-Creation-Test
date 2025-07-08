<?php

declare(strict_types=1);

namespace App\Components\Queries;

use App\Components\Models\Component;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\Components\Services\ComponentQueriesService;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;

final readonly class GetComponentsQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<Component> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Component> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ComponentRepositoryInterface $componentRepository,
        private ComponentQueriesService $componentQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<Component> */
    public function get(): DtosWithPaginationDto
    {
        $components = $this->componentRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Component $component) => $this->componentQueriesService->getComponentDtoFromModel(component: $component), $components->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $components);
    }
}
