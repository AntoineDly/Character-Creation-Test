<?php

declare(strict_types=1);

namespace App\Parameters\Commands;

use App\Base\Commands\CommandInterface;

final readonly class CreateParameterCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $type,
        public string $userId,
    ) {
    }
}
