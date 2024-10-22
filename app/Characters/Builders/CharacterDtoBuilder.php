<?php

declare(strict_types=1);

namespace App\Characters\Builders;

use App\Characters\Dtos\CharacterDto;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;

final class CharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    /**
     * @throws NotAValidUuidException
     */
    public function build(): CharacterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.');
        }

        $characterDto = new CharacterDto(
            id: $this->id
        );

        $this->id = '';

        return $characterDto;
    }
}
