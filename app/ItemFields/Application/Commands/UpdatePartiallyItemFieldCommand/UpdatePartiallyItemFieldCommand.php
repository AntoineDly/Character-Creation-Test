<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Commands\UpdatePartiallyItemFieldCommand;

use App\Shared\Application\Commands\CommandInterface;

final readonly class UpdatePartiallyItemFieldCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public ?string $value,
        public ?string $itemId,
        public ?string $parameterId,
    ) {
    }
}
