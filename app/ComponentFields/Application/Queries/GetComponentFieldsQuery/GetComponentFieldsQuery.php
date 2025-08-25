<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Queries\GetComponentFieldsQuery;

use App\ComponentFields\Domain\Models\ComponentField;
use App\ComponentFields\Domain\Services\ComponentFieldQueriesService;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetComponentFieldsQuery implements QueryInterface
{
    public function __construct(
        public SortedAndPaginatedDto $sortedAndPaginatedDto,
    ) {
    }
}
