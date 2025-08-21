<?php

declare(strict_types=1);

namespace App\Characters\Domain\Dtos;

use App\Games\Domain\Dtos\GameDto;
use App\Shared\Dtos\DtoInterface;

final readonly class CharacterWithGameDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public GameDto $gameDto,
    ) {
    }
}
