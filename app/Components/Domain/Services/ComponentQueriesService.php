<?php

declare(strict_types=1);

namespace App\Components\Domain\Services;

use App\Components\Domain\Dtos\ComponentDto\ComponentDto;
use App\Components\Domain\Dtos\ComponentDto\ComponentDtoBuilder;
use App\Components\Domain\Models\Component;
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
