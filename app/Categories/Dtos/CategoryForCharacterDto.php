<?php

declare(strict_types=1);

namespace App\Categories\Dtos;

use App\LinkedItems\Dtos\LinkedItemsForCharacterDto;
use App\Shared\Dtos\DtoInterface;

final readonly class CategoryForCharacterDto implements DtoInterface
{
    /** @param LinkedItemsForCharacterDto[] $linkedItemsForCharacterDto */
    public function __construct(
        public string $id,
        public string $name,
        public array $linkedItemsForCharacterDtos,
    ) {
    }
}
