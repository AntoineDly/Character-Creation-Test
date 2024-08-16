<?php

declare(strict_types=1);

namespace App\Games\Services;

use App\Games\Builders\GameDtoBuilder;
use App\Games\Dtos\GameDto;
use App\Games\Exceptions\GameNotFoundException;
use App\Games\Models\Game;
use App\Shared\Exceptions\InvalidClassException;
use Illuminate\Database\Eloquent\Model;

final readonly class GameQueriesService
{
    public function __construct(private GameDtoBuilder $gameDtoBuilder)
    {
    }

    public function getGameDtoFromModel(?Model $game): GameDto
    {
        if (is_null($game)) {
            throw new GameNotFoundException(message: 'Game not found', code: 404);
        }

        if (! $game instanceof Game) {
            throw new InvalidClassException(
                'Class was expected to be Game, '.get_class($game).' given.'
            );
        }

        /** @var array{'id': string, 'name': string} $gameData */
        $gameData = $game->toArray();

        return $this->gameDtoBuilder
            ->setId(id: $gameData['id'])
            ->setName(name: $gameData['name'])
            ->build();
    }
}
