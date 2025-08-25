<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Repositories;

use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
interface RepositoryInterface
{
    /**
     * @return LengthAwarePaginator<TModel>
     */
    public function index(SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator;

    /** @return Collection<int, TModel> */
    public function all(string $userId): Collection;

    /** @return null|TModel */
    public function findById(string $id): ?Model;

    /** @return null|TModel */
    public function findByAttribute(string $column, string|int $value): ?Model;

    /**
     * @param  array<string, string|int|bool|null>  $attributes
     */
    public function create(array $attributes): void;

    /**
     * @param  array<string, string|int|bool|null>  $attributes
     */
    public function update(string $key, string|int $value, array $attributes): ?bool;

    /**
     * @param  array<string, string|int|bool|null>  $attributes
     */
    public function updateById(string $id, array $attributes): ?bool;

    /** @return Builder<TModel> */
    public function newQuery(): Builder;

    /** @return Builder<TModel> */
    public function queryWhereUserId(string $userId): Builder;

    /**
     * @return LengthAwarePaginator<TModel>
     */
    public function getFromSortedAndPaginatedDto(SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator;
}
