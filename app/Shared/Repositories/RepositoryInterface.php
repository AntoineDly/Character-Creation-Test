<?php

declare(strict_types=1);

namespace App\Shared\Repositories;

use App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

interface RepositoryInterface
{
    /**
     * @return LengthAwarePaginator<Model>
     */
    public function index(SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator;

    /** @return Collection<int, Model> */
    public function all(string $userId): Collection;

    public function findById(string $id): ?Model;

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
}
