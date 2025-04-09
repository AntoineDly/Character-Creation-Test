<?php

declare(strict_types=1);

namespace App\Categories\Queries;

use App\Categories\Repositories\CategoryRepositoryInterface;
use App\Categories\Services\CategoryQueriesService;
use App\Shared\Builders\DtosWithPaginationDtoBuilder;
use App\Shared\Dtos\DtosWithPaginationDto;
use App\Shared\Dtos\SortedAndPaginatedDto;
use App\Shared\Queries\QueryInterface;
use App\Shared\Traits\DtosWithPaginationBuilderHelper;
use Illuminate\Database\Eloquent\Model;

final readonly class GetCategoriesQuery implements QueryInterface
{
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private CategoryQueriesService $categoryQueriesService,
        private SortedAndPaginatedDto $sortedAndPaginatedDto,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder,
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function get(): DtosWithPaginationDto
    {
        $categories = $this->categoryRepository->index($this->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Model $category) => $this->categoryQueriesService->getCategoryDtoFromModel(category: $category), $categories->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator(dtos: $dtos, lengthAwarePaginator: $categories);
    }
}
