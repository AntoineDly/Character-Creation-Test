<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Commands\UpdateComponentFieldCommand;

use App\Shared\Commands\CommandInterface;

final readonly class UpdateComponentFieldCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $value,
        public string $componentId,
        public string $parameterId,
    ) {
    }
}
