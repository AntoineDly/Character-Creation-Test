<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetAllCategoriesQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetAllCategoriesQuery implements QueryInterface
{
    public function __construct(
        public string $userId
    ) {
    }
}
