<?php

declare(strict_types=1);

namespace App\LinkedItems\Infrastructure\Repositories;

use App\LinkedItems\Domain\Models\LinkedItem;
use App\Shared\Infrastructure\Repositories\RepositoryTrait;

final readonly class LinkedItemRepository implements LinkedItemRepositoryInterface
{
    /** @use RepositoryTrait<LinkedItem> */
    use RepositoryTrait;

    public function __construct(LinkedItem $model)
    {
        $this->model = $model;
    }
}
