<?php

declare(strict_types=1);

namespace App\LinkedItems\Dtos;

use App\Shared\Dtos\DtoInterface;
use App\Shared\Dtos\SharedFieldDto\SharedFieldDto;

final readonly class LinkedItemsForCharacterDto implements DtoInterface
{
    /** @param SharedFieldDto[] $sharedFieldDtos */
    public function __construct(
        public string $id,
        public array $sharedFieldDtos,
    ) {
    }
}
