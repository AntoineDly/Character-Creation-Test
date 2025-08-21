<?php

declare(strict_types=1);

namespace App\Items\Infrastructure\Repositories;

use App\Items\Domain\Models\Item;
use App\Shared\Repositories\RepositoryTrait;

final readonly class ItemRepository implements ItemRepositoryInterface
{
    /** @use RepositoryTrait<Item> */
    use RepositoryTrait;

    public function __construct(Item $model)
    {
        $this->model = $model;
    }
}
