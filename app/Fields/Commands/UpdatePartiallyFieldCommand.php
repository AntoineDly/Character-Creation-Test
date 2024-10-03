<?php

declare(strict_types=1);

namespace App\Fields\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class UpdatePartiallyFieldCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public ?string $value,
        public ?string $linkedItemId,
        public ?string $parameterId,
    ) {
    }
}
