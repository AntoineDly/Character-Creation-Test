<?php

declare(strict_types=1);

namespace App\Items\Repositories;

use App\Items\Models\Item;
use App\Shared\Repositories\RepositoryTrait;

final readonly class ItemRepository implements ItemRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(Item $model)
    {
        $this->model = $model;
    }
}
