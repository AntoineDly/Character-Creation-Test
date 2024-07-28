<?php

declare(strict_types=1);

namespace App\Categories\Commands;

final readonly class AssociateCategoryGameCommand implements \App\Base\Commands\CommandInterface
{
    public function __construct(
        public string $categoryId,
        public string $gameId,
    ) {
    }
}
