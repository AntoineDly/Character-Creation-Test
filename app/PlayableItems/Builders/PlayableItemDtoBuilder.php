<?php

declare(strict_types=1);

namespace App\PlayableItems\Builders;

use App\Helpers\UuidHelper;
use App\PlayableItems\Dtos\PlayableItemDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;

final class PlayableItemDtoBuilder implements BuilderInterface
{
    private string $id = '';

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function build(): PlayableItemDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        $playableItemDto = new PlayableItemDto(
            id: $this->id
        );

        $this->id = '';

        return $playableItemDto;
    }
}
