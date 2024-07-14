<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Base\Queries\QueryInterface;
use App\Character\Dtos\CharacterDto;
use App\Character\Repositories\CharacterRepository\CharacterRepository;
use App\Character\Services\CharacterQueriesService;

final readonly class GetCharactersQuery implements QueryInterface
{
    public function __construct(
        private CharacterRepository $characterRepository,
        private CharacterQueriesService $characterQueriesService,
    ) {
    }

    /** @return CharacterDto[] */
    public function get(): array
    {
        $characters = $this->characterRepository->index();

        /** @var CharacterDto[] $charactersData */
        $charactersData = [];

        foreach ($characters as $character) {
            $charactersData[] = $this->characterQueriesService->getCharacterDtoFromModel(character: $character);
        }

        return $charactersData;
    }
}
