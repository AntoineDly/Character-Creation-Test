<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Repositories;

use App\PlayableItemFields\Models\PlayableItemField;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class PlayableItemFieldRepository extends AbstractRepository implements PlayableItemFieldRepositoryInterface
{
    public function __construct(PlayableItemField $model)
    {
        parent::__construct($model);
    }
}
