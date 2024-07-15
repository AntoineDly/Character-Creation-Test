<?php

declare(strict_types=1);

namespace App\Character\Dtos;

use App\Game\Dtos\GameDto;

final readonly class CharacterWithGameDto
{
    public function __construct(
        public string $id,
        public string $name,
        public GameDto $gameDto,
    ) {
    }
}
