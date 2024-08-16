<?php

declare(strict_types=1);

namespace App\Characters\Dtos;

use App\Games\Dtos\GameDto;
use App\Shared\Dtos\DtoInterface;

final readonly class CharacterWithGameDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public GameDto $gameDto,
    ) {
    }
}
