<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Commands\CreateItemFieldCommand;

use App\Shared\Application\Commands\CommandInterface;

final readonly class CreateItemFieldCommand implements CommandInterface
{
    public function __construct(
        public string $value,
        public string $itemId,
        public string $parameterId,
        public string $userId,
    ) {
    }
}
