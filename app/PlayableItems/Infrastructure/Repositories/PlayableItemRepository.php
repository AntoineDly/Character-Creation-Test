<?php

declare(strict_types=1);

namespace App\PlayableItems\Infrastructure\Repositories;

use App\PlayableItems\Domain\Models\PlayableItem;
use App\Shared\Repositories\RepositoryTrait;

final readonly class PlayableItemRepository implements PlayableItemRepositoryInterface
{
    /** @use RepositoryTrait<PlayableItem> */
    use RepositoryTrait;

    public function __construct(PlayableItem $model)
    {
        $this->model = $model;
    }
}
