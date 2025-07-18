<?php

declare(strict_types=1);

namespace App\Parameters\Queries;

use App\Parameters\Models\Parameter;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Parameters\Services\ParameterQueriesService;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use App\Shared\SortAndPagination\Traits\DtosWithPaginationBuilderHelper;

final readonly class GetParametersQuery implements QueryInterface
{
    /** @use DtosWithPaginationBuilderHelper<Parameter> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Parameter> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ParameterRepositoryInterface $parameterRepository,
        private ParameterQueriesService $parameterQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    /** @return DtosWithPaginationDto<Parameter> */
    public function get(): DtosWithPaginationDto
    {
        $parameters = $this->parameterRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Parameter $parameter) => $this->parameterQueriesService->getParameterDtoFromModel(parameter: $parameter), $parameters->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $parameters);
    }
}
