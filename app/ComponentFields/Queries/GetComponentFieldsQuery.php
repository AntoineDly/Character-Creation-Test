<?php

declare(strict_types=1);

namespace App\ComponentFields\Queries;

use App\ComponentFields\Repositories\ComponentFieldRepositoryInterface;
use App\ComponentFields\Services\ComponentFieldQueriesService;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class GetComponentFieldsQuery implements QueryInterface
{
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ComponentFieldQueriesService $componentFieldQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function get(): DtosWithPaginationDto
    {
        $componentFields = $this->componentFieldRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Model $componentField) => $this->componentFieldQueriesService->getComponentFieldDtoFromModel(componentField: $componentField), $componentFields->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $componentFields);
    }
}
