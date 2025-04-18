<?php

declare(strict_types=1);

namespace App\Categories\Dtos;

use App\LinkedItems\Dtos\LinkedItemForCharacterDto;
use App\Shared\Dtos\DtoInterface;

final readonly class CategoryForCharacterDto implements DtoInterface
{
    /** @param LinkedItemForCharacterDto[] $linkedItemForCharacterDtos */
    public function __construct(
        public string $id,
        public string $name,
        public array $linkedItemForCharacterDtos,
    ) {
    }
}
