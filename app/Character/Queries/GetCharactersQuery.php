<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Character\Dtos\CharacterDto;
use App\Character\Repositories\CharacterRepositoryInterface;
use App\Character\Services\CharacterQueriesService;
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
