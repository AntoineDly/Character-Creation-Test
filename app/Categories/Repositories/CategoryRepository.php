<?php

declare(strict_types=1);

namespace App\Categories\Repositories;

use App\Categories\Exceptions\CategoryNotFoundException;
use App\Categories\Models\Category;
use App\Shared\Exceptions\InvalidClassException;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class CategoryRepository extends AbstractRepository implements CategoryRepositoryInterface
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
