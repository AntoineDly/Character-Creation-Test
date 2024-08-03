<?php

declare(strict_types=1);

namespace App\Character\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateCharacterCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $gameId,
        public string $userId,
    ) {
    }
}
