<?php

declare(strict_types=1);

namespace App\Components\Repositories;

use App\Components\Exceptions\ComponentNotFoundException;
use App\Components\Models\Component;
use App\Shared\Exceptions\InvalidClassException;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class ComponentRepository extends AbstractRepository implements ComponentRepositoryInterface
{
    public function __construct(Component $model)
    {
        parent::__construct($model);
    }

    public function associateGame(string $componentId, string $gameId): void
    {
        $component = $this->findById(id: $componentId);

        if (is_null($component)) {
            throw new ComponentNotFoundException(message: 'Component not found', code: 404);
        }

        if (! $component instanceof Component) {
            throw new InvalidClassException(
                'Class was expected to be Component, '.get_class($component).' given.'
            );
        }

        $component->games()->attach($gameId);
    }

    public function associateCategory(string $componentId, string $categoryId): void
    {
        $component = $this->findById(id: $componentId);

        if (is_null($component)) {
            throw new ComponentNotFoundException(message: 'Component not found', code: 404);
        }

        if (! $component instanceof Component) {
            throw new InvalidClassException(
                'Class was expected to be Component, '.get_class($component).' given.'
            );
        }

        $component->categories()->attach($categoryId);
    }

    public function associateCharacter(string $componentId, string $characterId): void
    {
        $component = $this->findById(id: $componentId);

        if (is_null($component)) {
            throw new ComponentNotFoundException(message: 'Component not found', code: 404);
        }

        if (! $component instanceof Component) {
            throw new InvalidClassException(
                'Class was expected to be Component, '.get_class($component).' given.'
            );
        }

        $component->characters()->attach($characterId);
    }
}
