<?php

declare(strict_types=1);

namespace App\ComponentFields\Infrastructure\Repositories;

use App\ComponentFields\Domain\Models\ComponentField;
use App\Fields\Infrastructure\Repositories\FieldRepositoryTrait;

final readonly class ComponentFieldRepository implements ComponentFieldRepositoryInterface
{
    /** @use FieldRepositoryTrait<ComponentField> */
    use FieldRepositoryTrait;

    public function __construct(ComponentField $model)
    {
        $this->model = $model;
    }
}
