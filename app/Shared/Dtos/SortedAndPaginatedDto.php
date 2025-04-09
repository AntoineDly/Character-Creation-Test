<?php

declare(strict_types=1);

namespace App\Shared\Dtos;

final readonly class SortedAndPaginatedDto implements DtoInterface
{
    public function __construct(public string $sortOrder, public int $perPage, public int $page)
    {
    }

    /** @param array{'sortOrder': string, 'perPage': int, 'page': int} $data */
    public static function fromArray(array $data): SortedAndPaginatedDto
    {
        return new SortedAndPaginatedDto(
            sortOrder: $data['sortOrder'],
            perPage: $data['perPage'],
            page: $data['page'],
        );
    }
}
