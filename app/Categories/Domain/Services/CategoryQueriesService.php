<?php

declare(strict_types=1);

namespace App\Categories\Domain\Services;

use App\Categories\Domain\Dtos\CategoryDto\CategoryDto;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoBuilder;
use App\Categories\Domain\Models\Category;
use App\Helpers\AssertHelper;

final readonly class CategoryQueriesService
{
    public function __construct(
        private CategoryDtoBuilder $categoryDtoBuilder,
    ) {
    }

    public function getCategoryDtoFromModel(?Category $category): CategoryDto
    {
        $category = AssertHelper::isCategoryNotNull($category);

        return $this->categoryDtoBuilder
            ->setId(id: $category->id)
            ->setName(name: $category->name)
            ->build();
    }
}
