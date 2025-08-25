<?php

declare(strict_types=1);

namespace App\Categories\Domain\Dtos\CategoryDto;

use App\Shared\Domain\Dtos\DtoInterface;

final readonly class CategoryDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
