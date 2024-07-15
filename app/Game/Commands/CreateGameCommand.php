<?php

declare(strict_types=1);

namespace App\Game\Commands;

use App\Base\Commands\CommandInterface;

final readonly class CreateGameCommand implements CommandInterface
{
    public function __construct(
        public string $name,
    ) {
    }
}
