<?php

declare(strict_types=1);

namespace App\Fields\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class FieldDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $value,
    ) {
    }
}
