<?php

declare(strict_types=1);

namespace App\Shared\Dtos;

use App\Helpers\RequestHelper;
use App\Shared\Requests\SortedAndPaginatedRequest;

final readonly class SortedAndPaginatedDto implements DtoInterface
{
    public function __construct(public string $sortOrder, public int $perPage, public int $page, public string $userId)
    {
    }

    public static function fromSortedAndPaginatedRequest(SortedAndPaginatedRequest $request): self
    {
        /** @var array{'sortOrder': string, 'perPage': int, 'page': int} $data */
        $data = $request->validated();

        return new SortedAndPaginatedDto(
            sortOrder: $data['sortOrder'],
            perPage: $data['perPage'],
            page: $data['page'],
            userId: RequestHelper::getUserId($request)
        );
    }
}
