<?php

declare(strict_types=1);

namespace App\Categories\Services;

use App\Categories\Builders\CategoryDtoBuilder;
use App\Categories\Dtos\CategoryDto;
use App\Categories\Models\Category;
use App\Helpers\AssertHelper;

final readonly class CategoryQueriesService
{
    public function __construct(
        private CategoryDtoBuilder $categoryDtoBuilder,
    ) {
    }

    public function getCategoryDtoFromModel(?Category $category): CategoryDto
    {
        $category = AssertHelper::isCategory($category);

        return $this->categoryDtoBuilder
            ->setId(id: $category->id)
            ->setName(name: $category->name)
            ->build();
    }
}
