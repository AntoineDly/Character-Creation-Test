<?php

declare(strict_types=1);

namespace App\Fields\Infrastructure\Repositories;

use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\Infrastructure\Repositories\RepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 *
 * @extends RepositoryInterface<TModel>
 */
interface FieldRepositoryInterface extends RepositoryInterface
{
    /** @return TModel */
    public function findByIdWithParameters(string $id): ?Model;

    /**
     * @return LengthAwarePaginator<TModel>
     */
    public function allWithParameters(SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator;
}
