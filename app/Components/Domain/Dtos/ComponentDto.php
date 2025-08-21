<?php

declare(strict_types=1);

namespace App\Components\Domain\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class ComponentDto implements DtoInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
