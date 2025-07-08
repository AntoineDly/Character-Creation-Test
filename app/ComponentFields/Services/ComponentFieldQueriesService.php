<?php

declare(strict_types=1);

namespace App\ComponentFields\Services;

use App\ComponentFields\Builders\ComponentFieldDtoBuilder;
use App\ComponentFields\Dtos\ComponentFieldDto;
use App\ComponentFields\Models\ComponentField;
use App\Helpers\AssertHelper;

final readonly class ComponentFieldQueriesService
{
    public function __construct(
        private ComponentFieldDtoBuilder $componentFieldDtoBuilder,
    ) {
    }

    public function getComponentFieldDtoFromModel(?ComponentField $componentField): ComponentFieldDto
    {
        $componentField = AssertHelper::isComponentFieldNotNull($componentField);

        return $this->componentFieldDtoBuilder
            ->setId(id: $componentField->id)
            ->setValue(value: $componentField->value)
            ->build();
    }
}
