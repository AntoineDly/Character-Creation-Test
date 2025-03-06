<?php

declare(strict_types=1);

namespace App\LinkedItems\Builders;

use App\Helpers\UuidHelper;
use App\LinkedItems\Dtos\LinkedItemDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;

final class LinkedItemDtoBuilder implements BuilderInterface
{
    private string $id = '';

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function build(): LinkedItemDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        $linkedItemDto = new LinkedItemDto(
            id: $this->id,
        );

        $this->id = '';

        return $linkedItemDto;
    }
}
