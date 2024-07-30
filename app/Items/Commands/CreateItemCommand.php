<?php

declare(strict_types=1);

namespace App\Items\Commands;

use App\Base\Commands\CommandInterface;

final readonly class CreateItemCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $userId,
    ) {
    }
}
