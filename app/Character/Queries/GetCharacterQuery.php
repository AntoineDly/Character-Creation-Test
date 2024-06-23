<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Character\Dtos\CharacterDto;
use App\Character\Exceptions\CharacterNotFoundException;
use App\Character\Models\Character;
use App\Character\Repositories\CharacterRepository\CharacterRepository;

final readonly class GetCharacterQuery
{
    public function __construct(
        private CharacterRepository $characterRepository,
        private string $characterId,
    ) {
    }

    public function get(): CharacterDto
    {
        $character = $this->characterRepository->findById($this->characterId);

        if (! $character instanceof Character) {
            throw new CharacterNotFoundException(message: "Character not found with this id : {$this->characterId}", code: 404);
        }

        /** @var array{'id': string} $characterData */
        $characterData = $character->toArray();

        return new CharacterDto(
            id: $characterData['id']
        );
    }
}
