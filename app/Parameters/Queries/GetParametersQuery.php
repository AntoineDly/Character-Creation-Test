<?php

declare(strict_types=1);

namespace App\Parameters\Queries;

use App\Parameters\Dtos\ParameterDto;
use App\Parameters\Repositories\ParameterRepositoryInterface;
use App\Parameters\Services\ParameterQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

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

        return array_map(fn (?Model $parameter) => $this->parameterQueriesService->getParameterDtoFromModel(parameter: $parameter), $parameters->all());
    }
}
