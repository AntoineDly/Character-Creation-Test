<?php

declare(strict_types=1);

namespace App\Characters\Repositories;

use App\Characters\Models\Character;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class CharacterRepository extends AbstractRepository implements CharacterRepositoryInterface
{
    public function __construct(Character $model)
    {
        parent::__construct($model);
    }
}
