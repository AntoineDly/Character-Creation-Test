<?php

declare(strict_types=1);

namespace App\Game\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class GameDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
