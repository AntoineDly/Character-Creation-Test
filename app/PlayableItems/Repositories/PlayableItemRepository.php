<?php

declare(strict_types=1);

namespace App\PlayableItems\Repositories;

use App\PlayableItems\Models\PlayableItem;
use App\Shared\Repositories\AbstractRepository\RepositoryTrait;

final readonly class PlayableItemRepository implements PlayableItemRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(PlayableItem $model)
    {
        $this->model = $model;
    }
}
