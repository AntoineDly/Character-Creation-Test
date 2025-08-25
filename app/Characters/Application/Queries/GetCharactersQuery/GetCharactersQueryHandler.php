<?php

namespace App\Characters\Application\Queries\GetCharactersQuery;

use App\Categories\Application\Commands\CreateCategoryCommand\CreateCategoryCommand;
use App\Categories\Application\Queries\GetAllCategoriesQuery\GetAllCategoriesQuery;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Characters\Application\Queries\GetCharacterQuery\GetCharacterQuery;
use App\Characters\Domain\Dtos\CharacterDto\CharacterDto;
use App\Characters\Domain\Models\Character;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\Dtos\DtoInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDtoBuilder;
use App\Shared\Domain\SortAndPagination\Dtos\SortedAndPaginatedDto\SortedAndPaginatedDto;

final readonly class GetCharactersQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<Character> */
    use DtosWithPaginationBuilderHelper;

    /** @param DtosWithPaginationDtoBuilder<Character> $dtosWithPaginationDtoBuilder */
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
        DtosWithPaginationDtoBuilder $dtosWithPaginationDtoBuilder
    ) {
        $this->dtosWithPaginationDtoBuilder = $dtosWithPaginationDtoBuilder;
    }

    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetCharactersQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetCharactersQuery::class]);
        }
        $characters = $this->characterRepository->index($query->sortedAndPaginatedDto);

        $dtos = array_map(fn (?Character $character) => $this->characterQueriesService->getCharacterDtoFromModel(character: $character), $characters->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtos, $characters);
    }
}
