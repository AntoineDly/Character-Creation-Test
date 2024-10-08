<?php

declare(strict_types=1);

namespace App\Items\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateItemCommand implements CommandInterface
{
    public function __construct(
        public string $componentId,
        public string $categoryId,
        public string $userId,
    ) {
    }
}
