<?php

declare(strict_types=1);

namespace App\Characters\Queries;

use App\Characters\Dtos\CharacterDto;
use App\Characters\Repositories\CharacterRepositoryInterface;
use App\Characters\Services\CharacterQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetCharactersQuery implements QueryInterface
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
    ) {
    }

    /** @return CharacterDto[] */
    public function get(): array
    {
        $characters = $this->characterRepository->index();

        /** @var CharacterDto[] $charactersDtos */
        $charactersDtos = [];

        foreach ($characters as $character) {
            $charactersDtos[] = $this->characterQueriesService->getCharacterDtoFromModel(character: $character);
        }

        return $charactersDtos;
    }
}
