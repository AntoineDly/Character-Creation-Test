<?php

declare(strict_types=1);

namespace App\ComponentFields\Services;

use App\ComponentFields\Builders\ComponentFieldDtoBuilder;
use App\ComponentFields\Dtos\ComponentFieldDto;
use App\Helpers\AssertHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class ComponentFieldQueriesService
{
    public function __construct(
        private ComponentFieldDtoBuilder $componentFieldDtoBuilder,
    ) {
    }

    public function getComponentFieldDtoFromModel(?Model $componentField): ComponentFieldDto
    {
        $componentField = AssertHelper::isComponentField($componentField);

        return $this->componentFieldDtoBuilder
            ->setId(id: $componentField->id)
            ->setValue(value: $componentField->value)
            ->build();
    }
}
