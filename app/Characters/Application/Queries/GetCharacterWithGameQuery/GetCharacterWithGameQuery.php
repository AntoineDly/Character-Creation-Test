<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterWithGameQuery;

use App\Characters\Domain\Dtos\CharacterWithGameDto\CharacterWithGameDto;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetCharacterWithGameQuery implements QueryInterface
{
    public function __construct(
        public string $characterId,
    ) {
    }
}
