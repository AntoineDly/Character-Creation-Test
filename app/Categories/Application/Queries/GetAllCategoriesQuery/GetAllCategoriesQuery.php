<?php

declare(strict_types=1);

namespace App\Categories\Application\Queries\GetAllCategoriesQuery;

use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetAllCategoriesQuery implements QueryInterface
{
    public function __construct(
        public string $userId
    ) {
    }
}
