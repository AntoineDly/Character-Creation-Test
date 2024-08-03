<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Character\Dtos\CharacterWithGameDto;
use App\Character\Repositories\CharacterRepositoryInterface;
use App\Character\Services\CharacterQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetCharactersWithGameQuery implements QueryInterface
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
    ) {
    }

    /** @return CharacterWithGameDto[] */
    public function get(): array
    {
        $characters = $this->characterRepository->index();

        /** @var CharacterWithGameDto[] $charactersDtos */
        $charactersDtos = [];

        foreach ($characters as $character) {
            $charactersDtos[] = $this->characterQueriesService->getCharacterWithGameDtoFromModel(character: $character);
        }

        return $charactersDtos;
    }
}
