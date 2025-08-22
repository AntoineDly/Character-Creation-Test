<?php

declare(strict_types=1);

namespace App\Components\Application\Queries\GetComponentsQuery;

use App\Components\Domain\Models\Component;
use App\Components\Domain\Services\ComponentQueriesService;
use App\Components\Infrastructure\Repositories\ComponentRepositoryInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

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
