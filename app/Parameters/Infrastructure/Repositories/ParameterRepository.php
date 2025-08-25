<?php

declare(strict_types=1);

namespace App\Parameters\Infrastructure\Repositories;

use App\Parameters\Domain\Models\Parameter;
use App\Shared\Infrastructure\Repositories\RepositoryTrait;

final readonly class ParameterRepository implements ParameterRepositoryInterface
{
    /** @use RepositoryTrait<Parameter> */
    use RepositoryTrait;

    public function __construct(Parameter $model)
    {
        $this->model = $model;
    }
}
