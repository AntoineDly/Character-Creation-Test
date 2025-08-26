<?php

declare(strict_types=1);

namespace App\LinkedItems\Domain\Dtos\LinkedItemDto;

use App\Helpers\SelfInstantiateTrait;
use App\Helpers\UuidHelper;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;

final class LinkedItemDtoBuilder implements BuilderInterface
{
    use SelfInstantiateTrait;

    private string $id = '';

    public function setId(string $id): static
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
