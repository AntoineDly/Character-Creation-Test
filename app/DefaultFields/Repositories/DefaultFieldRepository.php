<?php

declare(strict_types=1);

namespace App\DefaultFields\Repositories;

use App\Base\Repositories\AbstractRepository\AbstractRepository;
use App\DefaultFields\Models\DefaultField;

final readonly class DefaultFieldRepository extends AbstractRepository implements DefaultFieldRepositoryInterface
{
    public function __construct(DefaultField $model)
    {
        parent::__construct($model);
    }
}
