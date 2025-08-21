<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterWithGameQuery;

use App\Characters\Domain\Dtos\CharacterWithGameDto;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
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
        $character = $this->characterRepository->getCharacterWithGameById(id: $this->characterId);

        return $this->characterQueriesService->getCharacterWithGameDtoFromModel(character: $character);
    }
}
