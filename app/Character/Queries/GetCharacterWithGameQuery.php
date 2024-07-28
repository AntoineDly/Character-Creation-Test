<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Base\Queries\QueryInterface;
use App\Character\Dtos\CharacterWithGameDto;
use App\Character\Repositories\CharacterRepositoryInterface;
use App\Character\Services\CharacterQueriesService;

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
