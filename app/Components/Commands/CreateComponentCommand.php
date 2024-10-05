<?php

declare(strict_types=1);

namespace App\Components\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateComponentCommand implements CommandInterface
{
    public function __construct(
        public string $userId,
    ) {
    }
}
