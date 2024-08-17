<?php

namespace App\Characters\Queries;

use App\Characters\Dtos\CharacterWithLinkedItemsDto;
use App\Characters\Repositories\CharacterRepositoryInterface;
use App\Characters\Services\CharacterQueriesService;
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
