<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Repositories;

use App\DefaultComponentFields\Models\DefaultComponentField;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class DefaultComponentFieldRepository extends AbstractRepository implements DefaultComponentFieldRepositoryInterface
{
    public function __construct(DefaultComponentField $model)
    {
        parent::__construct($model);
    }
}
