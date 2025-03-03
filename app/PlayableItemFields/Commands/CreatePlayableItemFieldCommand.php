<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreatePlayableItemFieldCommand implements CommandInterface
{
    public function __construct(
        public string $value,
        public string $playableItemId,
        public string $parameterId,
        public string $userId,
    ) {
    }
}
