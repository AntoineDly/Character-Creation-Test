<?php

declare(strict_types=1);

namespace App\LinkedItems\Builders;

use App\Helpers\UuidHelper;
use App\LinkedItems\Dtos\LinkedItemsForCharacterDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Enums\TypeFieldEnum;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Fields\Dtos\FieldDto;

final class LinkedItemsForCharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    /** @var FieldDto[] */
    private array $sharedFieldDtos = [];

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function addSharedFieldDto(FieldDto $sharedFieldDto): self
    {
        $this->sharedFieldDtos[] = $sharedFieldDto;

        return $this;
    }

    /** @param FieldDto[] $sharedFieldDtos */
    public function setSharedFieldDtos(array $sharedFieldDtos): self
    {
        $this->sharedFieldDtos = $sharedFieldDtos;

        return $this;
    }

    public function containsSharedFieldDtoWithSameNameAndBiggerWeightOrRemoveIfLower(string $name, TypeFieldEnum $type): bool
    {
        foreach ($this->sharedFieldDtos as $key => $sharedFieldDto) {
            if ($sharedFieldDto->name !== $name) {
                continue;
            }

            if ($sharedFieldDto->typeFieldEnum->weight() > $type->weight()) {
                return true;
            }

            unset($this->sharedFieldDtos[$key]);

            return false;
        }

        return false;
    }

    public function build(): LinkedItemsForCharacterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        $linkedItemsForCharacterDto = new LinkedItemsForCharacterDto(
            id: $this->id,
            sharedFieldDtos: $this->sharedFieldDtos
        );

        $this->id = '';
        $this->sharedFieldDtos = [];

        return $linkedItemsForCharacterDto;
    }
}
