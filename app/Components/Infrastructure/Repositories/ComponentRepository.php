<?php

declare(strict_types=1);

namespace App\Components\Infrastructure\Repositories;

use App\Components\Domain\Models\Component;
use App\Shared\Repositories\RepositoryTrait;

final readonly class ComponentRepository implements ComponentRepositoryInterface
{
    /** @use RepositoryTrait<Component> */
    use RepositoryTrait;

    public function __construct(Component $model)
    {
        $this->model = $model;
    }
}
