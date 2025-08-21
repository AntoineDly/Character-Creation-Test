<?php

declare(strict_types=1);

namespace App\Characters\Domain\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class CharacterDto implements DtoInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
