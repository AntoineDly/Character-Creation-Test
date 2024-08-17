<?php

declare(strict_types=1);

namespace App\Categories\Builders;

use App\Categories\Dtos\CategoryDto;
use App\Categories\Dtos\CategoryForCharacterDto;
use App\Helpers\UuidHelper;
use App\LinkedItems\Dtos\LinkedItemsForCharacterDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Dtos\SharedFieldDto\SharedFieldDto;
use App\Shared\Exceptions\NotAValidUuidException;
use App\Shared\Exceptions\StringIsEmptyException;

final class CategoryForCharacterDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    /** @var LinkedItemsForCharacterDto[] $linkedItemsForCharacterDto */
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
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.', code: 400);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty', code: 400);
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
