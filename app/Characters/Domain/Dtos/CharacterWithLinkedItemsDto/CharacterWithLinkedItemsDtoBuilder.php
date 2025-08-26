<?php

declare(strict_types=1);

namespace App\Characters\Domain\Dtos\CharacterWithLinkedItemsDto;

use App\Categories\Domain\Dtos\CategoryForCharacterDto\CategoryForCharacterDto;
use App\Categories\Domain\Dtos\CategoryForCharacterDto\CategoryForCharacterDtoCollection;
use App\Games\Domain\Dtos\GameDto\GameDto;
use App\Games\Infrastructure\Exceptions\GameNotFoundException;
use App\Helpers\UuidHelper;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;

final class CharacterWithLinkedItemsDtoBuilder implements BuilderInterface
{
    private string $id = '';

    private ?GameDto $gameDto = null;

    public function __construct(private CategoryForCharacterDtoCollection $categoryForCharacterDtoCollection = new CategoryForCharacterDtoCollection())
    {
    }

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setGameDto(GameDto $gameDto): static
    {
        $this->gameDto = $gameDto;

        return $this;
    }

    public function addCategoryForCharacterDto(CategoryForCharacterDto $linkedItemsForCharacterDto): static
    {
        $this->categoryForCharacterDtoCollection[] = $linkedItemsForCharacterDto;

        return $this;
    }

    public function setCategoryForCharacterDtoCollection(CategoryForCharacterDtoCollection $categoryForCharacterDtoCollection): static
    {
        $this->categoryForCharacterDtoCollection = $categoryForCharacterDtoCollection;

        return $this;
    }

    public function build(): CharacterWithLinkedItemsDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if (! $this->gameDto instanceof GameDto) {
            throw new GameNotFoundException('Game was not found to create the CharacterWithGameDto');
        }

        $characterWithLinkedItemDto = new CharacterWithLinkedItemsDto(
            id: $this->id,
            gameDto: $this->gameDto,
            categoryForCharacterDtoCollection: $this->categoryForCharacterDtoCollection
        );

        $this->id = '';
        $this->categoryForCharacterDtoCollection = new CategoryForCharacterDtoCollection();

        return $characterWithLinkedItemDto;
    }
}
