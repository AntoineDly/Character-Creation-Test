<?php

declare(strict_types=1);

namespace App\Components\Repositories;

use App\Components\Models\Component;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class ComponentRepository extends AbstractRepository implements ComponentRepositoryInterface
{
    public function __construct(Component $model)
    {
        parent::__construct($model);
    }
}
