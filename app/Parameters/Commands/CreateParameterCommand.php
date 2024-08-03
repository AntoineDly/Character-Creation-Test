<?php

declare(strict_types=1);

namespace App\Parameters\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateParameterCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $type,
        public string $userId,
    ) {
    }
}
