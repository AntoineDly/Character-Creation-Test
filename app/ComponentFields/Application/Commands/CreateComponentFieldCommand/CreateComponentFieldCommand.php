<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Commands\CreateComponentFieldCommand;

use App\Shared\Commands\CommandInterface;

final readonly class CreateComponentFieldCommand implements CommandInterface
{
    public function __construct(
        public string $value,
        public string $componentId,
        public string $parameterId,
        public string $userId,
    ) {
    }
}
