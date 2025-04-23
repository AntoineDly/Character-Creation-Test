<?php

declare(strict_types=1);

namespace App\ComponentFields\Repositories;

use App\ComponentFields\Models\ComponentField;
use App\Shared\Repositories\RepositoryTrait;

final readonly class ComponentFieldRepository implements ComponentFieldRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(ComponentField $model)
    {
        $this->model = $model;
    }
}
