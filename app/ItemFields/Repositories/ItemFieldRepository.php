<?php

declare(strict_types=1);

namespace App\ItemFields\Repositories;

use App\ItemFields\Models\ItemField;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class ItemFieldRepository extends AbstractRepository implements ItemFieldRepositoryInterface
{
    public function __construct(ItemField $model)
    {
        parent::__construct($model);
    }
}
