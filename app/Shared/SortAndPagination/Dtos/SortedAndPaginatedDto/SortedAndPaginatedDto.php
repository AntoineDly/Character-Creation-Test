<?php

declare(strict_types=1);

namespace App\Shared\SortAndPagination\Dtos\SortedAndPaginatedDto;

use App\Helpers\RequestHelper;
use App\Shared\Dtos\DtoInterface;

final readonly class SortedAndPaginatedDto implements DtoInterface
{
    public function __construct(public string $sortOrder, public int $perPage, public int $page, public string $userId)
    {
    }

    public static function fromSortedAndPaginatedRequest(SortedAndPaginatedRequest $request): static
    {
        /** @var array{'sortOrder': string, 'perPage': string|int, 'page': string|int} $data */
        $data = $request->validated();

        return new SortedAndPaginatedDto(
            sortOrder: $data['sortOrder'],
            perPage: (int) $data['perPage'],
            page: (int) $data['page'],
            userId: RequestHelper::getUserId($request)
        );
    }
}
