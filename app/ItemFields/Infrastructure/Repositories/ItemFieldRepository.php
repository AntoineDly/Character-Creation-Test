<?php

declare(strict_types=1);

namespace App\ItemFields\Infrastructure\Repositories;

use App\Fields\Infrastructure\Repositories\FieldRepositoryTrait;
use App\ItemFields\Domain\Models\ItemField;

final readonly class ItemFieldRepository implements ItemFieldRepositoryInterface
{
    /** @use FieldRepositoryTrait<ItemField> */
    use FieldRepositoryTrait;

    public function __construct(ItemField $model)
    {
        $this->model = $model;
    }
}
