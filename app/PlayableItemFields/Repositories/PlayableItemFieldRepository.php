<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Repositories;

use App\PlayableItemFields\Models\PlayableItemField;
use App\Shared\Repositories\AbstractRepository\RepositoryTrait;

final readonly class PlayableItemFieldRepository implements PlayableItemFieldRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(PlayableItemField $model)
    {
        $this->model = $model;
    }
}
