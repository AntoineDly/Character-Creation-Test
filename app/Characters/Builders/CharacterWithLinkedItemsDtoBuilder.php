<?php

declare(strict_types=1);

namespace App\Characters\Builders;

use App\Categories\Dtos\CategoryForCharacterDto;
use App\Characters\Dtos\CharacterWithLinkedItemsDto;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\NotAValidUuidException;
use App\Shared\Exceptions\StringIsEmptyException;

final class CharacterWithLinkedItemsDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    /** @var CategoryForCharacterDto[] */
    private array $categoryForCharacterDtos = [];

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

    public function addCategoryForCharacterDto(CategoryForCharacterDto $linkedItemsForCharacterDto): self
    {
        $this->categoryForCharacterDtos[] = $linkedItemsForCharacterDto;

        return $this;
    }

    /** @param CategoryForCharacterDto[] $categoryForCharacterDto */
    public function setCategoryForCharacterDtos(array $categoryForCharacterDto): self
    {
        $this->categoryForCharacterDtos = $categoryForCharacterDto;

        return $this;
    }

    public function build(): CharacterWithLinkedItemsDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.', code: 400);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty', code: 400);
        }

        $characterWithLinkedItemDto = new CharacterWithLinkedItemsDto(
            id: $this->id,
            name: $this->name,
            categoryForCharacterDtos: $this->categoryForCharacterDtos
        );

        $this->id = $this->name = '';
        $this->categoryForCharacterDtos = [];

        return $characterWithLinkedItemDto;
    }
}
