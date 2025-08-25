<?php

declare(strict_types=1);

namespace App\CategoryGames\Application\Commands\CreateCategoryGameCommand;

use App\Shared\Application\Commands\CommandInterface;

final readonly class CreateCategoryGameCommand implements CommandInterface
{
    public function __construct(
        public string $categoryId,
        public string $gameId,
    ) {
    }
}
