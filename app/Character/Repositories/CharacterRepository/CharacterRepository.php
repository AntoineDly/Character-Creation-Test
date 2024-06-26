<?php

declare(strict_types=1);

namespace App\Character\Repositories\CharacterRepository;

use App\Base\Repositories\AbstractRepository\AbstractRepository;
use App\Character\Models\Character;

final class CharacterRepository extends AbstractRepository implements CharacterRepositoryInterface
{
    public function __construct(Character $model)
    {
        parent::__construct($model);
    }
}
