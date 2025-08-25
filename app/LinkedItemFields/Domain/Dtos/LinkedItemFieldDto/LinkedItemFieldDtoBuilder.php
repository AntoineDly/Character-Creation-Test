<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Domain\Dtos\LinkedItemFieldDto;

use App\Helpers\UuidHelper;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;
use App\Shared\Infrastructure\Http\Exceptions\StringIsEmptyException;

final class LinkedItemFieldDtoBuilder implements BuilderInterface
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

    public function build(): LinkedItemFieldDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->value === '') {
            throw new StringIsEmptyException(data: ['field' => 'value']);
        }

        $linkedItemFieldDto = new LinkedItemFieldDto(
            id: $this->id,
            value: $this->value
        );

        $this->id = $this->value = '';

        return $linkedItemFieldDto;
    }
}
