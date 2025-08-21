<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Infrastructure\Repositories;

use App\PlayableItemFields\Domain\Models\PlayableItemField;
use App\Shared\Repositories\RepositoryTrait;

final readonly class PlayableItemFieldRepository implements PlayableItemFieldRepositoryInterface
{
    /** @use RepositoryTrait<PlayableItemField> */
    use RepositoryTrait;

    public function __construct(PlayableItemField $model)
    {
        $this->model = $model;
    }
}
