<?php

declare(strict_types=1);

namespace App\Items\Application\Commands\CreateItemCommand;

use App\Shared\Application\Commands\CommandInterface;

final readonly class CreateItemCommand implements CommandInterface
{
    public function __construct(
        public string $componentId,
        public string $categoryId,
        public string $userId,
    ) {
    }
}
