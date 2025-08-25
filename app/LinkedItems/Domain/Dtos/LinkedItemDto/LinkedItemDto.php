<?php

declare(strict_types=1);

namespace App\LinkedItems\Domain\Dtos\LinkedItemDto;

use App\Shared\Domain\Dtos\DtoInterface;

final readonly class LinkedItemDto implements DtoInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
