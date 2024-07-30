<?php

declare(strict_types=1);

namespace App\Categories\Repositories;

use App\Base\Exceptions\InvalidClassException;
use App\Base\Repositories\AbstractRepository\AbstractRepository;
use App\Categories\Exceptions\CategoryNotFoundException;
use App\Categories\Models\Category;

final class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
{
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }

    public function associateGame(string $categoryId, string $gameId): void
    {
        $category = $this->findById(id: $categoryId);

        if (is_null($category)) {
            throw new CategoryNotFoundException(message: 'Category not found', code: 404);
        }

        if (! $category instanceof Category) {
            throw new InvalidClassException(
                'Class was expected to be Category, '.get_class($category).' given.'
            );
        }

        $category->games()->attach($gameId);
    }
}
