<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Application\Commands\UpdatePartiallyLinkedItemFieldCommand;

use App\Shared\Application\Commands\CommandInterface;

final readonly class UpdatePartiallyLinkedItemFieldCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public ?string $value,
        public ?string $linkedItemId,
        public ?string $parameterId,
    ) {
    }
}
