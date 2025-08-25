<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetCategoryQuery;

use App\Categories\Domain\Dtos\CategoryDto\CategoryDto;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetCategoryQuery implements QueryInterface
{
    public function __construct(
        public string $categoryId,
    ) {
    }
}
