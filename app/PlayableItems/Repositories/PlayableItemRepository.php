<?php

declare(strict_types=1);

namespace App\PlayableItems\Repositories;

use App\PlayableItems\Models\PlayableItem;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class PlayableItemRepository extends AbstractRepository implements PlayableItemRepositoryInterface
{
    public function __construct(PlayableItem $model)
    {
        parent::__construct($model);
    }
}
