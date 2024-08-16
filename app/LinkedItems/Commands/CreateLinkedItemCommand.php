<?php

declare(strict_types=1);

namespace App\LinkedItems\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateLinkedItemCommand implements CommandInterface
{
    public function __construct(
        public string $itemId,
        public string $characterId,
        public string $userId,
    ) {
    }
}
