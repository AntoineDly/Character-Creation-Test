<?php

declare(strict_types=1);

namespace App\Character\Dtos;

use App\Base\Dtos\DtoInterface;

final readonly class CharacterDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
