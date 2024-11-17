<?php

declare(strict_types=1);

namespace App\Categories\Builders;

use App\Categories\Dtos\CategoryForCharacterDto;
use App\Helpers\UuidHelper;
use App\LinkedItems\Dtos\LinkedItemsForCharacterDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;

final class CategoryForCharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    /** @var LinkedItemsForCharacterDto[] */
    private array $linkedItemsForCharacterDtos = [];

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function addLinkedItemsForCharacterDto(LinkedItemsForCharacterDto $linkedItemsForCharacterDto): self
    {
        $this->linkedItemsForCharacterDtos[] = $linkedItemsForCharacterDto;

        return $this;
    }

    /** @param LinkedItemsForCharacterDto[] $linkedItemsForCharacterDtos */
    public function setLinkedItemsForCharacterDtos(array $linkedItemsForCharacterDtos): self
    {
        $this->linkedItemsForCharacterDtos = $linkedItemsForCharacterDtos;

        return $this;
    }

    public function build(): CategoryForCharacterDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException(data: ['field' => 'name']);
        }

        $categoryForCharacterDto = new CategoryForCharacterDto(
            id: $this->id,
            name: $this->name,
            linkedItemsForCharacterDtos: $this->linkedItemsForCharacterDtos
        );

        $this->id = $this->name = '';
        $this->linkedItemsForCharacterDtos = [];

        return $categoryForCharacterDto;
    }
}
