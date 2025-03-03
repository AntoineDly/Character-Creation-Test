<?php

declare(strict_types=1);

namespace App\ItemFields\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class ItemFieldDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $value,
    ) {
    }
}
