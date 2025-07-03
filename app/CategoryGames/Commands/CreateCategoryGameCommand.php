<?php

declare(strict_types=1);

namespace App\CategoryGames\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class CreateCategoryGameCommand implements CommandInterface
{
    public function __construct(
        public string $categoryId,
        public string $gameId,
    ) {
    }
}
