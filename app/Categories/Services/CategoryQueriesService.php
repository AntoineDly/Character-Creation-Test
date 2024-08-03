<?php

declare(strict_types=1);

namespace App\Categories\Services;

use App\Categories\Builders\CategoryDtoBuilder;
use App\Categories\Dtos\CategoryDto;
use App\Categories\Exceptions\CategoryNotFoundException;
use App\Categories\Models\Category;
use App\Shared\Exceptions\InvalidClassException;
use Illuminate\Database\Eloquent\Model;

final readonly class CategoryQueriesService
{
    public function __construct(
        private CategoryDtoBuilder $categoryDtoBuilder,
    ) {
    }

    public function getCategoryDtoFromModel(?Model $category): CategoryDto
    {
        if (is_null($category)) {
            throw new CategoryNotFoundException(message: 'Category not found', code: 404);
        }

        if (! $category instanceof Category) {
            throw new InvalidClassException(
                'Class was expected to be Category, '.get_class($category).' given.'
            );
        }

        /** @var array{'id': string, 'name': string} $categoryData */
        $categoryData = $category->toArray();

        return $this->categoryDtoBuilder
            ->setId(id: $categoryData['id'])
            ->setName(name: $categoryData['name'])
            ->build();
    }
}
