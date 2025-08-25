<?php

declare(strict_types=1);

namespace App\Parameters\Domain\Dtos\ParameterDto;

use App\Shared\Domain\Dtos\DtoInterface;

final readonly class ParameterDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public string $type,
    ) {
    }
}
