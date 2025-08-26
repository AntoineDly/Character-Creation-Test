<?php

declare(strict_types=1);

namespace App\Categories\Domain\Dtos\CategoryForCharacterDto;

use App\LinkedItems\Domain\Dtos\LinkedItemForCharacterDto\LinkedItemForCharacterDtoCollection;
use App\Shared\Domain\Dtos\DtoInterface;

final readonly class CategoryForCharacterDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public LinkedItemForCharacterDtoCollection $linkedItemForCharacterDtoCollection,
    ) {
    }
}
