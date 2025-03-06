<?php

declare(strict_types=1);

namespace App\LinkedItems\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class LinkedItemDto implements DtoInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
