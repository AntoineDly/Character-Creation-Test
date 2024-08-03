<?php

declare(strict_types=1);

namespace App\Character\Services;

use App\Character\Builders\CharacterDtoBuilder;
use App\Character\Builders\CharacterWithGameDtoBuilder;
use App\Character\Dtos\CharacterDto;
use App\Character\Dtos\CharacterWithGameDto;
use App\Character\Exceptions\CharacterNotFoundException;
use App\Character\Models\Character;
use App\Game\Repositories\GameRepositoryInterface;
use App\Game\Services\GameQueriesService;
use App\Shared\Exceptions\InvalidClassException;
use Illuminate\Database\Eloquent\Model;

final readonly class CharacterQueriesService
{
    public function __construct(
        private CharacterDtoBuilder $characterDtoBuilder,
        private CharacterWithGameDtoBuilder $characterWithGameDtoBuilder,
        private GameRepositoryInterface $gameRepository,
        private GameQueriesService $gameQueriesService
    ) {
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

    public function getCharacterWithGameDtoFromModel(?Model $character): CharacterWithGameDto
    {
        if (is_null($character)) {
            throw new CharacterNotFoundException(message: 'Character not found', code: 404);
        }

        if (! $character instanceof Character) {
            throw new InvalidClassException(
                'Class was expected to be Character, '.get_class($character).' given.'
            );
        }

        /** @var array{'id': string, 'name': string, 'game_id': string} $characterData */
        $characterData = $character->toArray();

        $game = $this->gameRepository->findById(id: $characterData['game_id']);
        $gameDto = $this->gameQueriesService->getGameDtoFromModel($game);

        return $this->characterWithGameDtoBuilder
            ->setId(id: $characterData['id'])
            ->setName(name: $characterData['name'])
            ->setGameDto(gameDto: $gameDto)
            ->build();
    }
}
