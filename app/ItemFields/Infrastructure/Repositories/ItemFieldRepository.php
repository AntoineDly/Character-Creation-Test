<?php

declare(strict_types=1);

namespace App\ItemFields\Infrastructure\Repositories;

use App\ItemFields\Domain\Models\ItemField;
use App\Shared\Repositories\RepositoryTrait;

final readonly class ItemFieldRepository implements ItemFieldRepositoryInterface
{
    /** @use RepositoryTrait<ItemField> */
    use RepositoryTrait;

    public function __construct(ItemField $model)
    {
        $this->model = $model;
    }
}
