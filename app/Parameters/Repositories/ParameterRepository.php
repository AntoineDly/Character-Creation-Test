<?php

declare(strict_types=1);

namespace App\Parameters\Repositories;

use App\Base\Repositories\AbstractRepository\AbstractRepository;
use App\Parameters\Models\Parameter;

final readonly class ParameterRepository extends AbstractRepository implements ParameterRepositoryInterface
{
    public function __construct(Parameter $model)
    {
        parent::__construct($model);
    }
}
