<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateDefaultItemFieldCommand implements CommandInterface
{
    public function __construct(
        public string $value,
        public string $itemId,
        public string $parameterId,
        public string $userId,
    ) {
    }
}
