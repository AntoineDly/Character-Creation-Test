<?php

declare(strict_types=1);

namespace App\Game\Repositories;

use App\Base\Repositories\AbstractRepository\AbstractRepository;
use App\Game\Models\Game;

final readonly class GameRepository extends AbstractRepository implements GameRepositoryInterface
{
    public function __construct(Game $model)
    {
        parent::__construct($model);
    }
}
