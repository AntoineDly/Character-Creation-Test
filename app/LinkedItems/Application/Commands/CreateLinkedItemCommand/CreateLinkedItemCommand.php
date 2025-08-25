<?php

declare(strict_types=1);

namespace App\LinkedItems\Application\Commands\CreateLinkedItemCommand;

use App\Shared\Application\Commands\CommandInterface;

final readonly class CreateLinkedItemCommand implements CommandInterface
{
    public function __construct(
        public string $playableItemId,
        public string $characterId,
        public string $userId,
    ) {
    }
}
