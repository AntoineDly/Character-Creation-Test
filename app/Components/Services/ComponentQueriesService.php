<?php

declare(strict_types=1);

namespace App\Components\Services;

use App\Components\Builders\ComponentDtoBuilder;
use App\Components\Dtos\ComponentDto;
use App\Components\Models\Component;
use App\Helpers\AssertHelper;

final readonly class ComponentQueriesService
{
    public function __construct(
        private ComponentDtoBuilder $componentDtoBuilder,
    ) {
    }

    public function getComponentDtoFromModel(?Component $component): ComponentDto
    {
        $component = AssertHelper::isComponentNotNull($component);

        return $this->componentDtoBuilder
            ->setId(id: $component->id)
            ->build();
    }
}
