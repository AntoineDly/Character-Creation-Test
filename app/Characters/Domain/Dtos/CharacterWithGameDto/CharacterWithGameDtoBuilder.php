<?php

declare(strict_types=1);

namespace App\Characters\Domain\Dtos\CharacterWithGameDto;

use App\Games\Domain\Dtos\GameDto\GameDto;
use App\Games\Infrastructure\Exceptions\GameNotFoundException;
use App\Helpers\SelfInstantiateTrait;
use App\Helpers\UuidHelper;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;

final class CharacterWithGameDtoBuilder implements BuilderInterface
{
    use SelfInstantiateTrait;

    private string $id;

    private ?GameDto $gameDto = null;

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setGameDto(GameDto $gameDto): static
    {
        $this->gameDto = $gameDto;

        return $this;
    }

    public function build(): CharacterWithGameDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if (! $this->gameDto instanceof GameDto) {
            throw new GameNotFoundException('Game was not found to create the CharacterWithGameDto');
        }

        $characterDto = new CharacterWithGameDto(
            id: $this->id,
            gameDto: $this->gameDto
        );

        $this->id = '';
        $this->gameDto = null;

        return $characterDto;
    }
}
