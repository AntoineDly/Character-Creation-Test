<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterQuery;

use App\Characters\Domain\Dtos\CharacterDto\CharacterDto;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Queries\QueryInterface;

final readonly class GetCharacterQuery implements QueryInterface
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
        private string $characterId,
    ) {
    }

    public function get(): CharacterDto
    {
        $character = $this->characterRepository->findById(id: $this->characterId);

        return $this->characterQueriesService->getCharacterDtoFromModel(character: $character);
    }
}
