<?php

namespace App\Shared\Builders\SharedFieldDtoBuilder;

use App\Helpers\UuidHelper;
use App\Parameters\Enums\TypeParameterEnum;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Dtos\SharedFieldDto\SharedFieldDto;
use App\Shared\Enums\TypeFieldEnum;
use App\Shared\Exceptions\InvalidClassException;
use App\Shared\Exceptions\StringIsEmptyException;

final class SharedFieldDtoBuilder implements BuilderInterface
{
    private string $sharedFieldId = '';
    private string $parameterId = '';
    private string $name = '';
    private string $value = '';
    private TypeParameterEnum|string $typeParameterEnum = '';
    private TypeFieldEnum|string $typeFieldEnum = '';

    public function setSharedFieldId(string $sharedFieldId): self
    {
        $this->sharedFieldId = $sharedFieldId;
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
        $this->typeParameterEnum =
            is_string($typeParameterEnum) ? TypeParameterEnum::tryFrom($typeParameterEnum) : $typeParameterEnum;
        return $this;
    }

    public function setTypeFieldEnum(TypeFieldEnum|string $typeFieldEnum): self
    {
        $this->typeFieldEnum =
            is_string($typeFieldEnum) ? TypeFieldEnum::tryFrom($typeFieldEnum) : $typeFieldEnum;
        return $this;
    }

    public function build(): SharedFieldDto
    {
        if (! UuidHelper::isValidUuid($this->sharedFieldId)) {
            throw new StringIsEmptyException('sharedFieldId field is empty', code: 400);
        }

        if (! UuidHelper::isValidUuid($this->parameterId)) {
            throw new StringIsEmptyException('parameterId field is empty', code: 400);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty', code: 400);
        }

        if ($this->value === '') {
            throw new StringIsEmptyException('value field is empty', code: 400);
        }

        if (!$this->typeParameterEnum instanceof TypeParameterEnum) {
            throw new InvalidClassException(
                'Enum was expected to be TypeParameterEnum, '.get_class($this->typeParameterEnum).' given.'
            );
        }

        if (!$this->typeFieldEnum instanceof TypeFieldEnum) {
            throw new InvalidClassException(
                'Enum was expected to be TypeFieldEnum, '.get_class($this->typeFieldEnum).' given.'
            );
        }

        $sharedFieldDto = new SharedFieldDto(
            sharedFieldId: $this->sharedFieldId,
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
