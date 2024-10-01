<?php

declare(strict_types=1);

namespace App\Games\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class UpdateGameCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $visibleForAll,
        public string $userId,
    ) {
    }
}
