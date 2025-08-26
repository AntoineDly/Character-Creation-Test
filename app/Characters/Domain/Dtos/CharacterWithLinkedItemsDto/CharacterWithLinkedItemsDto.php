<?php

declare(strict_types=1);

namespace App\Characters\Domain\Dtos\CharacterWithLinkedItemsDto;

use App\Categories\Domain\Dtos\CategoryForCharacterDto\CategoryForCharacterDtoCollection;
use App\Games\Domain\Dtos\GameDto\GameDto;
use App\Shared\Domain\Dtos\DtoInterface;

final readonly class CharacterWithLinkedItemsDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public GameDto $gameDto,
        public CategoryForCharacterDtoCollection $categoryForCharacterDtoCollection,
    ) {
    }
}
