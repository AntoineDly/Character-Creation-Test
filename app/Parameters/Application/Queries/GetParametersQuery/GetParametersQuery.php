<?php

declare(strict_types=1);

namespace App\Parameters\Application\Queries\GetParametersQuery;

use App\Parameters\Domain\Models\Parameter;
use App\Parameters\Domain\Services\ParameterQueriesService;
use App\Parameters\Infrastructure\Repositories\ParameterRepositoryInterface;
use App\Shared\Queries\QueryInterface;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

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
