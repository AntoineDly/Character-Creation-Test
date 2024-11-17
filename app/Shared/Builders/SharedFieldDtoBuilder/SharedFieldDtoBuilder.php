<?php

declare(strict_types=1);

namespace App\Shared\Builders\SharedFieldDtoBuilder;

use App\Helpers\UuidHelper;
use App\Parameters\Enums\TypeParameterEnum;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Dtos\SharedFieldDto\SharedFieldDto;
use App\Shared\Enums\TypeFieldEnum;
use App\Shared\Exceptions\Http\InvalidClassException;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;

final class SharedFieldDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $parameterId = '';

    private string $name = '';

    private string $value = '';

    private TypeParameterEnum|string $typeParameterEnum = '';

    private TypeFieldEnum|string $typeFieldEnum = '';

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setParameterId(string $parameterId): self
    {
        $this->parameterId = $parameterId;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setValue(string $value): self
    {
        $this->value = $value;

        return $this;
    }

    public function setTypeParameterEnum(TypeParameterEnum|string $typeParameterEnum): self
    {
        if (is_string($typeParameterEnum)) {
            $this->typeParameterEnum = TypeParameterEnum::tryFrom($typeParameterEnum) ?? '';

            return $this;
        }
        $this->typeParameterEnum = $typeParameterEnum;

        return $this;
    }

    public function setTypeFieldEnum(TypeFieldEnum|string $typeFieldEnum): self
    {
        if (is_string($typeFieldEnum)) {
            $this->typeFieldEnum = TypeFieldEnum::tryFrom($typeFieldEnum) ?? '';

            return $this;
        }
        $this->typeFieldEnum = $typeFieldEnum;

        return $this;
    }

    public function build(): SharedFieldDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if (! UuidHelper::isValidUuid($this->parameterId)) {
            throw new NotAValidUuidException(message: 'parameterId field is not a valid uuid.', data: ['value' => $this->id]);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException(data: ['field' => 'name']);
        }

        if ($this->value === '') {
            throw new StringIsEmptyException(data: ['field' => 'value']);
        }

        if (! $this->typeParameterEnum instanceof TypeParameterEnum) {
            throw new InvalidClassException(
                'Enum was expected to be TypeParameterEnum, '.$this->typeParameterEnum.' given.'
            );
        }

        if (! $this->typeFieldEnum instanceof TypeFieldEnum) {
            throw new InvalidClassException(
                'Enum was expected to be TypeFieldEnum, '.$this->typeFieldEnum.' given.'
            );
        }

        $sharedFieldDto = new SharedFieldDto(
            id: $this->id,
            parameterId: $this->parameterId,
            name: $this->name,
            value: $this->value,
            typeParameterEnum: $this->typeParameterEnum,
            typeFieldEnum: $this->typeFieldEnum
        );

        $this->name = $this->value = $this->typeParameterEnum = $this->typeFieldEnum = '';

        return $sharedFieldDto;
    }
}
