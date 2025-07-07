<?php

declare(strict_types=1);

namespace App\Parameters\Repositories;

use App\Parameters\Models\Parameter;
use App\Shared\Repositories\RepositoryTrait;

final readonly class ParameterRepository implements ParameterRepositoryInterface
{
    /** @use RepositoryTrait<Parameter> */
    use RepositoryTrait;

    public function __construct(Parameter $model)
    {
        $this->model = $model;
    }
}
