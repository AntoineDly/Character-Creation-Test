<?php

declare(strict_types=1);

namespace App\Games\Domain\Dtos\GameWithCategoriesAndPlayableItemsDto;

use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Helpers\SelfInstantiateTrait;
use App\Helpers\UuidHelper;
use App\PlayableItems\Domain\Dtos\PlayableItemDto\PlayableItemDtoCollection;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;
use App\Shared\Infrastructure\Http\Exceptions\StringIsEmptyException;

final class GameWithCategoriesAndPlayableItemsDtoBuilder implements BuilderInterface
{
    use SelfInstantiateTrait;

    private string $id = '';

    private string $name = '';

    public function __construct(
        private CategoryDtoCollection $categoryDtoCollection = new CategoryDtoCollection(),
        private PlayableItemDtoCollection $playableItemDtoCollection = new PlayableItemDtoCollection()
    ) {
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setCategoryDtoCollection(CategoryDtoCollection $categoryDtoCollection): static
    {
        $this->categoryDtoCollection = $categoryDtoCollection;

        return $this;
    }

    public function setPlayableItemDtoCollection(PlayableItemDtoCollection $playableItemDtoCollection): static
    {
        $this->playableItemDtoCollection = $playableItemDtoCollection;

        return $this;
    }

    public function build(): GameWithCategoriesAndPlayableItemsDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException(data: ['field' => 'name']);
        }

        $GameWithCategoriesAndPlayableItemsDto = new GameWithCategoriesAndPlayableItemsDto(
            id: $this->id,
            name: $this->name,
            categoryDtoCollection: $this->categoryDtoCollection,
            playableItemDtos: $this->playableItemDtoCollection
        );

        $this->id = $this->name = '';
        $this->categoryDtoCollection = new CategoryDtoCollection();
        $this->playableItemDtoCollection = new PlayableItemDtoCollection();

        return $GameWithCategoriesAndPlayableItemsDto;
    }
}
