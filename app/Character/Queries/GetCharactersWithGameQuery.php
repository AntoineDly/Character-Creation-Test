<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Base\Queries\QueryInterface;
use App\Character\Dtos\CharacterWithGameDto;
use App\Character\Repositories\CharacterRepositoryInterface;
use App\Character\Services\CharacterQueriesService;

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

        /** @var CharacterWithGameDto[] $charactersData */
        $charactersData = [];

        foreach ($characters as $character) {
            $charactersData[] = $this->characterQueriesService->getCharacterWithGameDtoFromModel(character: $character);
        }

        return $charactersData;
    }
}
