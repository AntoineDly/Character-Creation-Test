<?php

declare(strict_types=1);

namespace App\Items\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class AssociateItemGameCommand implements CommandInterface
{
    public function __construct(
        public string $itemId,
        public string $gameId,
    ) {
    }
}
