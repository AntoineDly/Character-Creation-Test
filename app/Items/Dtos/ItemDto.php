<?php

declare(strict_types=1);

namespace App\Items\Dtos;

use App\Base\Dtos\DtoInterface;

final readonly class ItemDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
