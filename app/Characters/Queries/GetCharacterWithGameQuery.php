<?php

declare(strict_types=1);

namespace App\Characters\Queries;

use App\Characters\Dtos\CharacterWithGameDto;
use App\Characters\Repositories\CharacterRepositoryInterface;
use App\Characters\Services\CharacterQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetCharacterWithGameQuery implements QueryInterface
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
        private string $characterId,
    ) {
    }

    public function get(): CharacterWithGameDto
    {
        $character = $this->characterRepository->findById(id: $this->characterId);

        return $this->characterQueriesService->getCharacterWithGameDtoFromModel(character: $character);
    }
}
