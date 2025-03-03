<?php

declare(strict_types=1);

namespace App\PlayableItems\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreatePlayableItemCommand implements CommandInterface
{
    public function __construct(
        public string $itemId,
        public string $gameId,
        public string $userId,
    ) {
    }
}
