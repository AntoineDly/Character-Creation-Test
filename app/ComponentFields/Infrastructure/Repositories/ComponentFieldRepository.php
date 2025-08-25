<?php

declare(strict_types=1);

namespace App\ComponentFields\Infrastructure\Repositories;

use App\ComponentFields\Domain\Models\ComponentField;
use App\Shared\Infrastructure\Repositories\RepositoryTrait;

final readonly class ComponentFieldRepository implements ComponentFieldRepositoryInterface
{
    /** @use RepositoryTrait<ComponentField> */
    use RepositoryTrait;

    public function __construct(ComponentField $model)
    {
        $this->model = $model;
    }
}
