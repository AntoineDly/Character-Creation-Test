<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharactersWithGameQuery;

use App\Characters\Application\Queries\GetCharactersQuery\GetCharactersQuery;
use App\Characters\Domain\Dtos\CharacterWithGameDto\CharacterWithGameDtoCollection;
use App\Characters\Domain\Models\Character;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationBuilderHelper;
use App\Shared\Domain\SortAndPagination\Dtos\DtosWithPaginationDto\DtosWithPaginationDto;

final readonly class GetCharactersWithGameQueryHandler implements QueryHandlerInterface
{
    /** @use DtosWithPaginationBuilderHelper<Character> */
    use DtosWithPaginationBuilderHelper;

    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): DtosWithPaginationDto
    {
        if (! $query instanceof GetCharactersQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetCharactersQuery::class]);
        }
        $characters = $this->characterRepository->index($query->sortedAndPaginatedDto);

        $dtoCollection = CharacterWithGameDtoCollection::fromMap(fn (?Character $character) => $this->characterQueriesService->getCharacterWithGameDtoFromModel(character: $character), $characters->items());

        return $this->getDtosWithPaginationDtoFromDtosAndLengthAwarePaginator($dtoCollection, $characters);
    }
}
