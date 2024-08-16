<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Repositories;

use App\DefaultItemFields\Models\DefaultItemField;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class DefaultItemFieldRepository extends AbstractRepository implements DefaultItemFieldRepositoryInterface
{
    public function __construct(DefaultItemField $model)
    {
        parent::__construct($model);
    }
}
