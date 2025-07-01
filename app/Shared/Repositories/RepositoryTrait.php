<?php

declare(strict_types=1);

namespace App\Shared\Repositories;

use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

trait RepositoryTrait
{
    private readonly Model $model;

    /**
     * @return LengthAwarePaginator<Model>
     */
    public function index(SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator
    {
        return $this->getWithPaginate(
            $this->model->query()->where(column: 'user_id', operator: '=', value: $sortedAndPaginatedDto->userId),
            $sortedAndPaginatedDto
        );
    }

    /** @return Collection<int, Model> */
    public function all(string $userId): Collection
    {
        return $this->model->query()->where(column: 'user_id', operator: '=', value: $userId)->get();
    }

    public function findById(string $id): ?Model
    {
        return $this->findByAttribute(column: 'id', value: $id);
    }

    public function findByAttribute(string $column, string|int $value): ?Model
    {
        return $this->model->query()->where(column: $column, operator: '=', value: $value)->first();
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
    public function updateById(string $id, array $attributes): ?bool
    {
        return $this->update(column: 'id', value: $id, attributes: $attributes);
    }

    /**
     * @param  array<string, string|int|bool|null>  $attributes
     */
    public function update(string $column, string|int $value, array $attributes): ?bool
    {
        return $this->model->query()->where(column: $column, operator: '=', value: $value)->sole()->update($attributes);
    }

    /**
     * @param  Builder<Model>  $builder
     * @return LengthAwarePaginator<Model>
     */
    private function getWithPaginate(Builder $builder, SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator
    {
        return $builder
            ->orderBy(column: 'id', direction: $sortedAndPaginatedDto->sortOrder)
            ->paginate(perPage: $sortedAndPaginatedDto->perPage, page: $sortedAndPaginatedDto->page);
    }
}
