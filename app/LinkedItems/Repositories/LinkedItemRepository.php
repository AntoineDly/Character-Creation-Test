<?php

declare(strict_types=1);

namespace App\LinkedItems\Repositories;

use App\LinkedItems\Models\LinkedItem;
use App\Shared\Repositories\RepositoryTrait;

final readonly class LinkedItemRepository implements LinkedItemRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(LinkedItem $model)
    {
        $this->model = $model;
    }
}
