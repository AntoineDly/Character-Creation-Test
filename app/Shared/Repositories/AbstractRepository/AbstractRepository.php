<?php

declare(strict_types=1);

namespace App\Shared\Repositories\AbstractRepository;

use App\Shared\Dtos\SortedAndPaginatedDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

abstract readonly class AbstractRepository implements AbstractRepositoryInterface
{
    public function __construct(protected Model $model)
    {
    }

    /**
     * @return LengthAwarePaginator<Model>
     */
    public function index(SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator
    {
        return $this->model->newQuery()
            ->orderBy(column: 'id', direction: $sortedAndPaginatedDto->sortOrder)
            ->paginate(perPage: $sortedAndPaginatedDto->perPage, page: $sortedAndPaginatedDto->page);
    }

    public function findById(string $id): ?Model
    {
        return $this->findByAttribute(column: 'id', value: $id);
    }

    public function findByAttribute(string $column, string|int $value): ?Model
    {
        return $this->model->query()->firstWhere(column: $column, operator: '=', value: $value);
    }

    /**
     * @param  array<string, string|int|bool|null>  $attributes
     */
    public function create(array $attributes): void
    {
        $this->model->query()->create($attributes);
    }

    /**
     * @param  array<string, string|int|bool|null>  $attributes
     */
    public function update(string $key, string|int $value, array $attributes): ?bool
    {
        return $this->model->query()->where($key, $value)->sole()->update($attributes);
    }

    /**
     * @param  array<string, string|int|bool|null>  $attributes
     */
    public function updateById(string $id, array $attributes): ?bool
    {
        return $this->model->query()->where('id', $id)->sole()->update($attributes);
    }
}
