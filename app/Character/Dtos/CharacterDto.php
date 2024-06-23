<?php

declare(strict_types=1);

namespace App\Character\Dtos;

final readonly class CharacterDto
{
    public function __construct(
        public string $id,
    ) {
    }
}
