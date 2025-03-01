<?php

declare(strict_types=1);

namespace App\Games\Builders;

use App\Categories\Dtos\CategoryDto;
use App\Games\Dtos\GameWithCategoriesAndItemsDto;
use App\Helpers\UuidHelper;
use App\Items\Dtos\ItemDto;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;
use App\Shared\Exceptions\Http\StringIsEmptyException;

final class GameWithCategoriesAndItemsDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private string $name = '';

    /** @var CategoryDto[] */
    private array $categoryDtos = [];

    /** @var ItemDto[] */
    private array $itemDtos = [];

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

    /** @param CategoryDto[] $categoryDtos */
    public function setCategoryDtos(array $categoryDtos): self
    {
        $this->categoryDtos = $categoryDtos;

        return $this;
    }

    /** @param ItemDto[] $itemDtos */
    public function setItemDtos(array $itemDtos): self
    {
        $this->itemDtos = $itemDtos;

        return $this;
    }

    public function build(): GameWithCategoriesAndItemsDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException(data: ['field' => 'name']);
        }

        $gameWithCategoriesAndItemsDto = new GameWithCategoriesAndItemsDto(
            id: $this->id,
            name: $this->name,
            categoryDtos: $this->categoryDtos,
            itemDtos: $this->itemDtos
        );

        $this->id = $this->name = '';
        $this->categoryDtos = $this->itemDtos = [];

        return $gameWithCategoriesAndItemsDto;
    }
}
