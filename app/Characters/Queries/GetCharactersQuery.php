<?php

declare(strict_types=1);

namespace App\Characters\Queries;

use App\Characters\Dtos\CharacterDto;
use App\Characters\Repositories\CharacterRepositoryInterface;
use App\Characters\Services\CharacterQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

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

        return array_map(fn (?Model $character) => $this->characterQueriesService->getCharacterDtoFromModel(character: $character), $characters->all());
    }
}
