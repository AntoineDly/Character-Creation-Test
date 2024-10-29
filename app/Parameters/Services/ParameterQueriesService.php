<?php

declare(strict_types=1);

namespace App\Parameters\Services;

use App\Helpers\AssertHelper;
use App\Parameters\Builders\ParameterDtoBuilder;
use App\Parameters\Dtos\ParameterDto;
use Illuminate\Database\Eloquent\Model;

final readonly class ParameterQueriesService
{
    public function __construct(
        private ParameterDtoBuilder $parameterDtoBuilder,
    ) {
    }

    public function getParameterDtoFromModel(?Model $parameter): ParameterDto
    {
        $parameter = AssertHelper::isParameter($parameter);

        return $this->parameterDtoBuilder
            ->setId(id: $parameter->id)
            ->setName(name: $parameter->name)
            ->setType(type: $parameter->type)
            ->build();
    }
}
