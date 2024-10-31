<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class DefaultComponentFieldDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $value,
    ) {
    }
}
