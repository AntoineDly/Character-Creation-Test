<?php

declare(strict_types=1);

namespace App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto;

use App\Helpers\RequestHelper;
use App\Shared\Domain\Dtos\DtoInterface;
use App\Shared\Infrastructure\Requests\SortedAndPaginatedRequest;

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
