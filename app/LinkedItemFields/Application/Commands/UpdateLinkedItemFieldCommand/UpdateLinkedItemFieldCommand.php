<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Application\Commands\UpdateLinkedItemFieldCommand;

use App\Shared\Commands\CommandInterface;

final readonly class UpdateLinkedItemFieldCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $value,
        public string $linkedItemId,
        public string $parameterId,
    ) {
    }
}
