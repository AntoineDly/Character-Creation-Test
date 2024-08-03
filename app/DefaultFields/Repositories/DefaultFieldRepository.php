<?php

declare(strict_types=1);

namespace App\DefaultFields\Repositories;

use App\DefaultFields\Models\DefaultField;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class DefaultFieldRepository extends AbstractRepository implements DefaultFieldRepositoryInterface
{
    public function __construct(DefaultField $model)
    {
        parent::__construct($model);
    }
}
