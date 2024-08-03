<?php

declare(strict_types=1);

namespace App\Categories\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateCategoryCommand implements CommandInterface
{
    public function __construct(
        public string $name,
        public string $userId,
    ) {
    }
}
