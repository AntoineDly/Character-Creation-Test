<?php

declare(strict_types=1);

namespace App\ItemFields\Repositories;

use App\ItemFields\Models\ItemField;
use App\Shared\Repositories\AbstractRepository\RepositoryTrait;

final readonly class ItemFieldRepository implements ItemFieldRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(ItemField $model)
    {
        $this->model = $model;
    }
}
