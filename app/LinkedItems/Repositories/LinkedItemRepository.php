<?php

declare(strict_types=1);

namespace App\LinkedItems\Repositories;

use App\LinkedItems\Models\LinkedItem;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class LinkedItemRepository extends AbstractRepository implements LinkedItemRepositoryInterface
{
    public function __construct(LinkedItem $model)
    {
        parent::__construct($model);
    }
}
