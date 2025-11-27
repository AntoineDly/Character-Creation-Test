<?php

declare(strict_types=1);

namespace App\Fields\Infrastructure\Repositories;

use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;
use App\Shared\Infrastructure\Repositories\RepositoryTrait;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of Model
 */
trait FieldRepositoryTrait
{
    /** @use RepositoryTrait<TModel> */
    use RepositoryTrait;

    /** @return TModel */
    public function findByIdWithParameters(string $id): ?Model
    {
        return $this->queryWhereAttribute('id', $id)->with('parameter')->first();
    }

    /**
     * @return LengthAwarePaginator<TModel>
     */
    public function allWithParameters(SortedAndPaginatedDto $sortedAndPaginatedDto): LengthAwarePaginator
    {
        return $this
            ->queryWhereUserId($sortedAndPaginatedDto->userId)
            ->with('parameter')
            ->orderBy(column: 'id', direction: $sortedAndPaginatedDto->sortOrder)
            ->paginate(perPage: $sortedAndPaginatedDto->perPage, page: $sortedAndPaginatedDto->page);
    }
}
