<?php

declare(strict_types=1);

namespace App\Parameters\Domain\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class ParameterDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $type,
    ) {
    }
}
