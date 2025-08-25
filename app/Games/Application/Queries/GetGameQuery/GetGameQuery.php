<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetGameQuery;

use App\Games\Domain\Dtos\GameDto\GameDto;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetGameQuery implements QueryInterface
{
    public function __construct(
        public string $gameId,
    ) {
    }
}
