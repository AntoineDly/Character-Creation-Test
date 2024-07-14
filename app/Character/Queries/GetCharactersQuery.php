<?php

declare(strict_types=1);

namespace App\Character\Queries;

use App\Base\Queries\QueryInterface;
use App\Character\Builders\CharacterDtoBuilder;
use App\Character\Dtos\CharacterDto;
use App\Character\Exceptions\CharacterNotFoundException;
use App\Character\Models\Character;
use App\Character\Repositories\CharacterRepository\CharacterRepository;

final readonly class GetCharactersQuery implements QueryInterface
{
    public function __construct(
        private CharacterRepository $characterRepository,
        private CharacterDtoBuilder $characterDtoBuilder,
    ) {
    }

    /** @return CharacterDto[] */
    public function get(): array
    {
        $characters = $this->characterRepository->index();

        /** @var CharacterDto[] $charactersData */
        $charactersData = [];

        foreach ($characters as $character) {
            if (! $character instanceof Character) {
                throw new CharacterNotFoundException(message: 'Character not found', code: 404);
            }

            /** @var array{'id': string, 'name': string} $characterData */
            $characterData = $character->toArray();

            $charactersData[] = $this->characterDtoBuilder
                ->setId(id: $characterData['id'])
                ->setName(name: $characterData['name'])
                ->build();

        }

        return $charactersData;
    }
}
