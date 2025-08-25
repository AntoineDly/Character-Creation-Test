<?php

declare(strict_types=1);

namespace App\Parameters\Application\Queries\GetParameterQuery;

use App\Parameters\Domain\Dtos\ParameterDto\ParameterDto;
use App\Parameters\Domain\Services\ParameterQueriesService;
use App\Parameters\Infrastructure\Repositories\ParameterRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetParameterQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ParameterRepositoryInterface $parameterRepository,
        private ParameterQueriesService $parameterQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): ParameterDto
    {
        if (! $query instanceof GetParameterQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetParameterQuery::class]);
        }
        $parameter = $this->parameterRepository->findById(id: $query->parameterId);

        return $this->parameterQueriesService->getParameterDtoFromModel(parameter: $parameter);
    }
}
