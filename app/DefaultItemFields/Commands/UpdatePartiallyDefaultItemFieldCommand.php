<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class UpdatePartiallyDefaultItemFieldCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public ?string $value,
        public ?string $itemId,
        public ?string $parameterId,
    ) {
    }
}
