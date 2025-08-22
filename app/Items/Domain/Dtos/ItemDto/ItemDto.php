<?php

declare(strict_types=1);

namespace App\Items\Domain\Dtos\ItemDto;

use App\Shared\Dtos\DtoInterface;

final readonly class ItemDto implements DtoInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
