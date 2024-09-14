<?php

declare(strict_types=1);

namespace App\Components\Services;

use App\Components\Builders\ComponentDtoBuilder;
use App\Components\Dtos\ComponentDto;
use App\Helpers\AssertHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class ComponentQueriesService
{
    public function __construct(
        private ComponentDtoBuilder $componentDtoBuilder,
    ) {
    }

    public function getComponentDtoFromModel(?Model $component): ComponentDto
    {
        $component = AssertHelper::isComponent($component);

        return $this->componentDtoBuilder
            ->setId(id: $component->id)
            ->setName(name: $component->name)
            ->build();
    }
}
