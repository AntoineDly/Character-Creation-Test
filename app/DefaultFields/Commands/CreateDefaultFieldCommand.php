<?php

declare(strict_types=1);

namespace App\DefaultFields\Commands;

use App\Base\Commands\CommandInterface;

final readonly class CreateDefaultFieldCommand implements CommandInterface
{
    public function __construct(
        public string $value,
        public string $itemId,
        public string $parameterId,
        public string $userId,
    ) {
    }
}
