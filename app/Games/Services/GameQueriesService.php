<?php

declare(strict_types=1);

namespace App\Games\Services;

use App\Games\Builders\GameDtoBuilder;
use App\Games\Dtos\GameDto;
use App\Games\Exceptions\GameNotFoundException;
use App\Helpers\AssertHelper;
use App\Shared\Exceptions\Http\InvalidClassException;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;
use Illuminate\Database\Eloquent\Model;

final readonly class GameQueriesService
{
    public function __construct(private GameDtoBuilder $gameDtoBuilder)
    {
    }

    /**
     * @throws NotAValidUuidException
     * @throws GameNotFoundException
     * @throws InvalidClassException
     * @throws StringIsEmptyException
     */
    public function getGameDtoFromModel(?Model $game): GameDto
    {
        $game = AssertHelper::isGame($game);

        return $this->gameDtoBuilder
            ->setId(id: $game->id)
            ->setName(name: $game->name)
            ->build();
    }
}
