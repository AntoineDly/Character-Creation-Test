<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterWithLinkedItemsQuery;

use App\Characters\Domain\Dtos\CharacterWithLinkedItemsDto\CharacterWithLinkedItemsDto;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetCharacterWithLinkedItemsQuery implements QueryInterface
{
    public function __construct(
        public string $characterId,
    ) {
    }
}
