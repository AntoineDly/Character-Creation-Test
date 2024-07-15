<?php

declare(strict_types=1);

namespace App\Game\Services;

use App\Base\Exceptions\InvalidClassException;
use App\Game\Builders\GameDtoBuilder;
use App\Game\Dtos\GameDto;
use App\Game\Exceptions\GameNotFoundException;
use App\Game\Models\Game;
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
