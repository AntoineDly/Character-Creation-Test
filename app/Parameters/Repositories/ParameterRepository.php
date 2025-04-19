<?php

declare(strict_types=1);

namespace App\Parameters\Repositories;

use App\Parameters\Models\Parameter;
use App\Shared\Repositories\AbstractRepository\RepositoryTrait;

final readonly class ParameterRepository implements ParameterRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(Parameter $model)
    {
        $this->model = $model;
    }
}
