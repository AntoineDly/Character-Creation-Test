<?php

declare(strict_types=1);

namespace App\Parameters\Services;

use App\Helpers\AssertHelper;
use App\Parameters\Builders\ParameterDtoBuilder;
use App\Parameters\Dtos\ParameterDto;
use App\Parameters\Models\Parameter;

final readonly class ParameterQueriesService
{
    public function __construct(
        private ParameterDtoBuilder $parameterDtoBuilder,
    ) {
    }

    public function getParameterDtoFromModel(?Parameter $parameter): ParameterDto
    {
        $parameter = AssertHelper::isParameterNotNull($parameter);

        return $this->parameterDtoBuilder
            ->setId(id: $parameter->id)
            ->setName(name: $parameter->name)
            ->setType(type: $parameter->type)
            ->build();
    }
}
