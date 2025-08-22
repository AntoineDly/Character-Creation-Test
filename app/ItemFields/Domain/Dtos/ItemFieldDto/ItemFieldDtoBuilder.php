<?php

declare(strict_types=1);

namespace App\ItemFields\Domain\Dtos\ItemFieldDto;

use App\Helpers\UuidHelper;
use App\Shared\Dtos\BuilderInterface;
use App\Shared\Http\Exceptions\NotAValidUuidException;
use App\Shared\Http\Exceptions\StringIsEmptyException;

final class ItemFieldDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $value = '';

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }

    public function build(): ItemFieldDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->value === '') {
            throw new StringIsEmptyException(data: ['field' => 'value']);
        }

        $itemFieldDto = new ItemFieldDto(
            id: $this->id,
            value: $this->value
        );

        $this->id = $this->value = '';

        return $itemFieldDto;
    }
}
