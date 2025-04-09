<?php

declare(strict_types=1);

namespace App\Components\Queries;

use App\Components\Repositories\ComponentRepositoryInterface;
use App\Components\Services\ComponentQueriesService;
use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Dtos\DtosWithPaginationDto;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Queries\QueryInterface;
use App\Shared\Traits\DtosWithPaginationBuilderHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class GetComponentsQuery implements QueryInterface
{
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private ComponentRepositoryInterface $componentRepository,
        private ComponentQueriesService $componentQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function get(): DtosWithPaginationDto
    {
        $components = $this->componentRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Model $component) => $this->componentQueriesService->getComponentDtoFromModel(component: $component), $components->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $components);
    }
}
