<?php

declare(strict_types=1);

namespace App\ItemFields\Domain\Dtos\ItemFieldDto;

use App\Shared\Domain\Dtos\DtoInterface;

final readonly class ItemFieldDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $value,
    ) {
    }
}
