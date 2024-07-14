<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Character\Dtos\CharacterDto;
use App\Character\Exceptions\CharacterNotFoundException;
use App\Character\Models\Character;
use App\Character\Repositories\CharacterRepository\CharacterRepository;
use Illuminate\Database\Eloquent\Model;

final readonly class GetCharactersQuery
{
    public function __construct(
        private CharacterRepository $characterRepository,
    ) {
    }

    /** @return CharacterDto[] */
    public function get(): array
    {
        $characters = $this->characterRepository->index();

        $charactersData = [];

        foreach($characters as $character) {
            if (! $character instanceof Character) {
                throw new CharacterNotFoundException(message: 'Character not found', code: 404);
            }

            /** @var array{'id': string} $characterData */
            $characterData = $character->toArray();

            $charactersData[] = new CharacterDto(
                id: $characterData['id']
            );

        }

        return $charactersData;
    }
}
