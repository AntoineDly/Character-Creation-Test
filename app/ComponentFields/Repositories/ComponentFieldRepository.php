<?php

declare(strict_types=1);

namespace App\ComponentFields\Repositories;

use App\ComponentFields\Models\ComponentField;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class ComponentFieldRepository extends AbstractRepository implements ComponentFieldRepositoryInterface
{
    public function __construct(ComponentField $model)
    {
        parent::__construct($model);
    }
}
