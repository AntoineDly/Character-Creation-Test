<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Base\Queries\QueryInterface;
use App\Character\Dtos\CharacterDto;
use App\Character\Repositories\CharacterRepository\CharacterRepository;
use App\Character\Services\CharacterQueriesService;

final readonly class GetCharacterQuery implements QueryInterface
{
    public function __construct(
        private CharacterRepository $characterRepository,
        private CharacterQueriesService $characterQueriesService,
        private string $characterId,
    ) {
    }

    public function get(): CharacterDto
    {
        $character = $this->characterRepository->findById($this->characterId);

        return $this->characterQueriesService->getCharacterDtoFromModel(character: $character);
    }
}
