<?php

declare(strict_types=1);

namespace App\Parameters\Queries;

use App\Parameters\Dtos\ParameterDto;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Parameters\Services\ParameterQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetParameterQuery implements QueryInterface
{
    public function __construct(
        private ParameterRepositoryInterface $parameterRepository,
        private ParameterQueriesService $parameterQueriesService,
        private string $parameterId,
    ) {
    }

    public function get(): ParameterDto
    {
        $parameter = $this->parameterRepository->findById(id: $this->parameterId);

        return $this->parameterQueriesService->getParameterDtoFromModel(parameter: $parameter);
    }
}
