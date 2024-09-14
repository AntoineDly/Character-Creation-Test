<?php

declare(strict_types=1);

namespace App\Categories\Services;

use App\Categories\Builders\CategoryDtoBuilder;
use App\Categories\Dtos\CategoryDto;
use App\Helpers\AssertHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class CategoryQueriesService
{
    public function __construct(
        private CategoryDtoBuilder $categoryDtoBuilder,
    ) {
    }

    public function getCategoryDtoFromModel(?Model $category): CategoryDto
    {
        $category = AssertHelper::isCategory($category);

        return $this->categoryDtoBuilder
            ->setId(id: $category->id)
            ->setName(name: $category->name)
            ->build();
    }
}
