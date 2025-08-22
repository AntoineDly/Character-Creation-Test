<?php

declare(strict_types=1);

namespace App\Characters\Domain\Dtos\CharacterWithLinkedItemsDto;

use App\Categories\Domain\Dtos\CategoryForCharacterDto\CategoryForCharacterDto;
use App\Games\Domain\Dtos\GameDto\GameDto;
use App\Shared\Dtos\DtoInterface;

final readonly class CharacterWithLinkedItemsDto implements DtoInterface
{
    /** @param CategoryForCharacterDto[] $categoryForCharacterDtos */
    public function __construct(
        public string $id,
        public GameDto $gameDto,
        public array $categoryForCharacterDtos,
    ) {
    }
}
