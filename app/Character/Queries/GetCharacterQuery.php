<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Character\Dtos\CharacterDto;
use App\Character\Repositories\CharacterRepositoryInterface;
use App\Character\Services\CharacterQueriesService;
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
