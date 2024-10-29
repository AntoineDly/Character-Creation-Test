<?php

declare(strict_types=1);

namespace App\Parameters\Queries;

use App\Parameters\Dtos\ParameterDto;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Parameters\Services\ParameterQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetParametersQuery implements QueryInterface
{
    public function __construct(
        private ParameterRepositoryInterface $parameterRepository,
        private ParameterQueriesService $parameterQueriesService,
    ) {
    }

    /** @return ParameterDto[] */
    public function get(): array
    {
        $parameters = $this->parameterRepository->index();

        /** @var ParameterDto[] $parametersDtos */
        $parametersDtos = [];

        foreach ($parameters as $parameter) {
            $parametersDtos[] = $this->parameterQueriesService->getParameterDtoFromModel(parameter: $parameter);
        }

        return $parametersDtos;
    }
}
