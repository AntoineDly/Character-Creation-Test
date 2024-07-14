<?php

declare(strict_types=1);

namespace App\Character\Services;

use App\Base\Exceptions\InvalidClassException;
use App\Character\Builders\CharacterDtoBuilder;
use App\Character\Dtos\CharacterDto;
use App\Character\Exceptions\CharacterNotFoundException;
use App\Character\Models\Character;
use Illuminate\Database\Eloquent\Model;

final readonly class CharacterQueriesService
{
    public function __construct(private CharacterDtoBuilder $characterDtoBuilder)
    {
    }

    public function getCharacterDtoFromModel(?Model $character): CharacterDto
    {
        if (is_null($character)) {
            throw new CharacterNotFoundException(message: 'Character not found', code: 404);
        }

        if (! $character instanceof Character) {
            throw new InvalidClassException(
                'Class was expected to be Character, '.get_class($character).' given.'
            );
        }

        /** @var array{'id': string, 'name': string} $characterData */
        $characterData = $character->toArray();

        return $this->characterDtoBuilder
            ->setId(id: $characterData['id'])
            ->setName(name: $characterData['name'])
            ->build();
    }
}
