<?php

declare(strict_types=1);

namespace App\Parameters\Application\Queries\GetParametersQuery;

use App\Parameters\Domain\Dtos\ParameterDto\ParameterDtoCollection;
use App\Parameters\Domain\Models\Parameter;
use App\Parameters\Domain\Services\ParameterQueriesService;
use App\Parameters\Infrastructure\Repositories\ParameterRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;

final readonly class GetParametersQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<Parameter> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Parameter> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private ParameterRepositoryInterface $parameterRepository,
        private ParameterQueriesService $parameterQueriesService,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetParametersQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetParametersQuery::class]);
        }
        $parameters = $this->parameterRepository->index($query->sortedAndPaginatedDto);

        $dtos = ParameterDtoCollection::fromMap(fn (?Parameter $parameter) => $this->parameterQueriesService->getParameterDtoFromModel(parameter: $parameter), $parameters->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $parameters);
    }
}
