<?php

declare(strict_types=1);

namespace App\Fields\Builders;

use App\Fields\Dtos\FieldDto;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;

final class FieldDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $value = '';

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function build(): FieldDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->value === '') {
            throw new StringIsEmptyException(data: ['field' => 'value']);
        }

        $defaultItemFieldDto = new FieldDto(
            id: $this->id,
            value: $this->value
        );

        $this->id = $this->value = '';

        return $defaultItemFieldDto;
    }
}
