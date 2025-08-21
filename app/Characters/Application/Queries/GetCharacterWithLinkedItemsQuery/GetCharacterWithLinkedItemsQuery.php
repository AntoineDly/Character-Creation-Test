<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterWithLinkedItemsQuery;

use App\Characters\Domain\Dtos\CharacterWithLinkedItemsDto;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Queries\QueryInterface;

final readonly class GetCharacterWithLinkedItemsQuery implements QueryInterface
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
        private string $characterId,
    ) {
    }

    public function get(): CharacterWithLinkedItemsDto
    {
        $character = $this->characterRepository->getCharacterWithLinkedItemsById(id: $this->characterId);

        return $this->characterQueriesService->getCharacterWithLinkedItemsDtoFromModel(character: $character);
    }
}
