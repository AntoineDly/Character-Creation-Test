<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateLinkedItemFieldCommand implements CommandInterface
{
    public function __construct(
        public string $value,
        public string $linkedItemId,
        public string $parameterId,
        public string $userId,
    ) {
    }
}
