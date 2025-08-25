<?php

declare(strict_types=1);

namespace App\Games\Domain\Dtos\GameDto;

use App\Shared\Domain\Dtos\DtoInterface;

final readonly class GameDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
    ) {
    }
}
