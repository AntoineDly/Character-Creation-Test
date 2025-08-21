<?php

declare(strict_types=1);

namespace App\ComponentFields\Domain\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class ComponentFieldDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $value,
    ) {
    }
}
