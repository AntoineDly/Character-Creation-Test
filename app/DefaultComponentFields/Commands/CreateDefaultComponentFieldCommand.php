<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateDefaultComponentFieldCommand implements CommandInterface
{
    public function __construct(
        public string $value,
        public string $componentId,
        public string $parameterId,
        public string $userId,
    ) {
    }
}
