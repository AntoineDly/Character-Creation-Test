<?php

declare(strict_types=1);

namespace App\Games\Application\Commands\CreateGameCommand;

use App\Shared\Commands\CommandInterface;

final readonly class CreateGameCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public bool $visibleForAll,
        public string $userId,
    ) {
    }
}
