<?php

declare(strict_types=1);

namespace App\Game\Repositories;

use App\Game\Models\Game;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class GameRepository extends AbstractRepository implements GameRepositoryInterface
{
    public function __construct(Game $model)
    {
        parent::__construct($model);
    }
}
