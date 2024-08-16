<?php

declare(strict_types=1);

namespace App\Components\Services;

use App\Components\Builders\ComponentDtoBuilder;
use App\Components\Dtos\ComponentDto;
use App\Components\Exceptions\ComponentNotFoundException;
use App\Components\Models\Component;
use App\Shared\Exceptions\InvalidClassException;
use Illuminate\Database\Eloquent\Model;

final readonly class ComponentQueriesService
{
    public function __construct(
        private ComponentDtoBuilder $componentDtoBuilder,
    ) {
    }

    public function getComponentDtoFromModel(?Model $component): ComponentDto
    {
        if (is_null($component)) {
            throw new ComponentNotFoundException(message: 'Category not found', code: 404);
        }

        if (! $component instanceof Component) {
            throw new InvalidClassException(
                'Class was expected to be Component, '.get_class($component).' given.'
            );
        }

        /** @var array{'id': string, 'name': string} $componentData */
        $componentData = $component->toArray();

        return $this->componentDtoBuilder
            ->setId(id: $componentData['id'])
            ->setName(name: $componentData['name'])
            ->build();
    }
}
