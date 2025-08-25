<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetAllGamesWithoutRequestedCategoryQuery;

use App\Games\Domain\Dtos\GameDto\GameDtoCollection;
use App\Games\Domain\Models\Game;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetAllGamesWithoutRequestedCategoryQuery implements QueryInterface
{
    public function __construct(
        public string $userId,
        public string $categoryId,
    ) {
    }
}
