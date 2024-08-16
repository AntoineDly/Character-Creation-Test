<?php

declare(strict_types=1);

namespace App\Items\Repositories;

use App\Items\Models\Item;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class ItemRepository extends AbstractRepository implements ItemRepositoryInterface
{
    public function __construct(Item $model)
    {
        parent::__construct($model);
    }
}
