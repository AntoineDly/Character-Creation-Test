<?php

declare(strict_types=1);

namespace App\Characters\Dtos;

use App\Categories\Dtos\CategoryForCharacterDto;
use App\Shared\Dtos\DtoInterface;

final readonly class CharacterWithLinkedItemsDto implements DtoInterface
{
    /** @param CategoryForCharacterDto[] $categoryForCharacterDtos */
    public function __construct(
        public string $id,
        public string $name,
        public array $categoryForCharacterDtos,
    ) {
    }
}
