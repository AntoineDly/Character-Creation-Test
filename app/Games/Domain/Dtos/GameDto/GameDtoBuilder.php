<?php

declare(strict_types=1);

namespace App\Games\Domain\Dtos\GameDto;

use App\Helpers\SelfInstantiateTrait;
use App\Helpers\UuidHelper;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;
use App\Shared\Infrastructure\Http\Exceptions\StringIsEmptyException;

final class GameDtoBuilder implements BuilderInterface
{
    use SelfInstantiateTrait;

    private string $id = '';

    private string $name = '';

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function build(): GameDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException(data: ['field' => 'name']);
        }

        $gameDto = new GameDto(
            id: $this->id,
            name: $this->name
        );

        $this->id = $this->name = '';

        return $gameDto;
    }
}
