<?php

declare(strict_types=1);

namespace App\Items\Commands;

use App\Shared\Commands\CommandInterface;

final readonly class AssociateItemCategoryCommand implements CommandInterface
{
    public function __construct(
        public string $itemId,
        public string $categoryId,
    ) {
    }
}
