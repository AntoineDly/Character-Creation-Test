<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetCategoryQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetCategoryQuery implements QueryInterface
{
    public function __construct(
        public string $categoryId,
    ) {
    }
}
