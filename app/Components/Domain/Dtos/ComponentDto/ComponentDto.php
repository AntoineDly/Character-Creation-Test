<?php

declare(strict_types=1);

namespace App\Components\Domain\Dtos\ComponentDto;

use App\Shared\Domain\Dtos\DtoInterface;

final readonly class ComponentDto implements DtoInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
