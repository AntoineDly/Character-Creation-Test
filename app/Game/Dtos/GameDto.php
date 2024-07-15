<?php

declare(strict_types=1);

namespace App\Game\Dtos;

final readonly class GameDto
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
