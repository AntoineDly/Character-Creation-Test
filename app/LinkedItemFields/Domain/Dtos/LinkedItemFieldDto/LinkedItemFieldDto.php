<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Domain\Dtos\LinkedItemFieldDto;

use App\Shared\Dtos\DtoInterface;

final readonly class LinkedItemFieldDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $value,
    ) {
    }
}
