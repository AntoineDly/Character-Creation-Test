<?php

declare(strict_types=1);

namespace App\Shared\Repositories;

use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait RepositoryTrait
{
    /** @var TModel */
    private readonly Model $model;

    /**
     * @return LengthAwarePaginator<TModel>
     */
    public function index(SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator
    {
        return $this->getFromSortedAndPaginatedDto($sortedAndPaginatedDto);
    }

    /** @return Collection<int, TModel> */
    public function all(string $userId): Collection
    {
        return $this->queryWhereUserId($userId)->get();
    }

    /** @return null|TModel */
    public function findById(string $id): ?Model
    {
        return $this->findByAttribute(column: 'id', value: $id);
    }

    /** @return null|TModel */
    public function findByAttribute(string $column, string|int $value): ?Model
    {
        return $this->queryWhereAttribute($column, $value)->first();
    }

    /** @param  array<string, string|int|bool|null>  $attributes */
    public function create(array $attributes): void
    {
        $this->newQuery()->create($attributes);
    }

    /** @param  array<string, string|int|bool|null>  $attributes */
    public function updateById(string $id, array $attributes): ?bool
    {
        return $this->update(column: 'id', value: $id, attributes: $attributes);
    }

    /** @param  array<string, string|int|bool|null>  $attributes */
    public function update(string $column, string|int $value, array $attributes): ?bool
    {
        return $this->queryWhereAttribute($column, $value)->sole()->update($attributes);
    }

    /** @return Builder<TModel> */
    public function newQuery(): Builder
    {
        return $this->model->query();
    }

    /** @return Builder<TModel> */
    public function queryWhereUserId(string $userId): Builder
    {
        return $this->queryWhereAttribute('user_id', $userId);
    }

    /** @return Builder<TModel> */
    public function queryWhereAttribute(string $column, string|int $value): Builder
    {
        return $this->newQuery()->where(column: $column, operator: '=', value: $value);
    }

    /** @return LengthAwarePaginator<TModel> */
    public function getFromSortedAndPaginatedDto(SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator
    {
        return $this
            ->queryWhereUserId($sortedAndPaginatedDto->userId)
            ->orderBy(column: 'id', direction: $sortedAndPaginatedDto->sortOrder)
            ->paginate(perPage: $sortedAndPaginatedDto->perPage, page: $sortedAndPaginatedDto->page);
    }
}
