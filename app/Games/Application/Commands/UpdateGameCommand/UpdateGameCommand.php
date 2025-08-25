<?php

declare(strict_types=1);

namespace App\Games\Application\Commands\UpdateGameCommand;

use App\Shared\Application\Commands\CommandInterface;

final readonly class UpdateGameCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $visibleForAll
    ) {
    }
}
