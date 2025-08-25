<?php

declare(strict_types=1);

namespace App\Parameters\Application\Commands\CreateParameterCommand;

use App\Shared\Application\Commands\CommandInterface;

final readonly class CreateParameterCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $type,
        public string $userId,
    ) {
    }
}
