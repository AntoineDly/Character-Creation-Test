<?php

declare(strict_types=1);

namespace App\LinkedItems\Dtos;

use App\Shared\Dtos\DtoInterface;
use App\Shared\Fields\Dtos\FieldDto;

final readonly class LinkedItemsForCharacterDto implements DtoInterface
{
    /** @param FieldDto[] $sharedFieldDtos */
    public function __construct(
        public string $id,
        public array $sharedFieldDtos,
    ) {
    }
}
