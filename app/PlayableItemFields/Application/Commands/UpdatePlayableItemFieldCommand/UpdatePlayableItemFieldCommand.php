<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Application\Commands\UpdatePlayableItemFieldCommand;

use App\Shared\Commands\CommandInterface;

final readonly class UpdatePlayableItemFieldCommand implements CommandInterface
{
    public function __construct(
        public string $id,
        public string $value,
        public string $playableItemId,
        public string $parameterId,
    ) {
    }
}
