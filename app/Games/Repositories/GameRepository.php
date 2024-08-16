<?php

declare(strict_types=1);

namespace App\Games\Repositories;

use App\Games\Models\Game;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class GameRepository extends AbstractRepository implements GameRepositoryInterface
{
    public function __construct(Game $model)
    {
        parent::__construct($model);
    }
}
