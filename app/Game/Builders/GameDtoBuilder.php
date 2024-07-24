<?php

declare(strict_types=1);

namespace App\Game\Builders;

use App\Base\Builders\BuilderInterface;
use App\Base\Exceptions\NotAValidUuidException;
use App\Base\Exceptions\StringIsEmptyException;
use App\Game\Dtos\GameDto;
use App\Helpers\UuidHelper;

final class GameDtoBuilder implements BuilderInterface
{
    public string $id = '';

    public string $name = '';

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function build(): GameDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.', code: 400);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty', code: 400);
        }

        $gameDto = new GameDto(
            id: $this->id,
            name: $this->name
        );

        $this->id = $this->name = '';

        return $gameDto;
    }
}
