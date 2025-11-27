<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Infrastructure\Repositories;

use App\Fields\Infrastructure\Repositories\FieldRepositoryTrait;
use App\PlayableItemFields\Domain\Models\PlayableItemField;

final readonly class PlayableItemFieldRepository implements PlayableItemFieldRepositoryInterface
{
    /** @use FieldRepositoryTrait<PlayableItemField> */
    use FieldRepositoryTrait;

    public function __construct(PlayableItemField $model)
    {
        $this->model = $model;
    }
}
