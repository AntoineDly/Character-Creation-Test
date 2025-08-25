<?php

declare(strict_types=1);

namespace App\Games\Application\Queries\GetGamesQuery;

use App\Games\Domain\Dtos\GameDto\GameDtoCollection;
use App\Games\Domain\Models\Game;
use App\Games\Domain\Services\GameQueriesService;
use App\Games\Infrastructure\Repositories\GameRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\Dtos\DtoCollectionInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetGamesQuery implements QueryInterface
{
    public function __construct(
        public SortedAndPaginatedDto $sortedAndPaginatedDto,
    ) {
    }
}
