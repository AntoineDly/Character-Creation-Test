<?php

declare(strict_types=1);

namespace App\Fields\Repositories;

use App\Fields\Models\Field;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class FieldRepository extends AbstractRepository implements FieldRepositoryInterface
{
    public function __construct(Field $model)
    {
        parent::__construct($model);
    }
}
