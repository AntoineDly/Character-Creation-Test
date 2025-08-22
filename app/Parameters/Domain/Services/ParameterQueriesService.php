<?php

declare(strict_types=1);

namespace App\Parameters\Domain\Services;

use App\Helpers\AssertHelper;
use App\Parameters\Domain\Dtos\ParameterDto\ParameterDto;
use App\Parameters\Domain\Dtos\ParameterDto\ParameterDtoBuilder;
use App\Parameters\Domain\Models\Parameter;

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
