<?php

declare(strict_types=1);

namespace App\Categories\Dtos;

final readonly class CategoryDto
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
