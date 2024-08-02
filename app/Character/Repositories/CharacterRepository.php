<?php

declare(strict_types=1);

namespace App\Character\Repositories;

use App\Base\Repositories\AbstractRepository\AbstractRepository;
use App\Character\Models\Character;

final readonly class CharacterRepository extends AbstractRepository implements CharacterRepositoryInterface
{
    public function __construct(Character $model)
    {
        parent::__construct($model);
    }
}
