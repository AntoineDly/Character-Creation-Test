<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Commands\UpdatePartiallyComponentFieldCommand;

use App\Shared\Application\Commands\CommandInterface;

final readonly class UpdatePartiallyComponentFieldCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public ?string $value,
        public ?string $componentId,
        public ?string $parameterId,
    ) {
    }
}
