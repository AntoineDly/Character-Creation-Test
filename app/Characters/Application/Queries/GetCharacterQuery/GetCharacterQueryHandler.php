<?php

namespace App\Characters\Application\Queries\GetCharacterQuery;

use App\Categories\Application\Commands\CreateCategoryCommand\CreateCategoryCommand;
use App\Categories\Application\Queries\GetAllCategoriesQuery\GetAllCategoriesQuery;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\Dtos\DtoInterface;
use App\Characters\Domain\Dtos\CharacterDto\CharacterDto;

final readonly class GetCharacterQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): CharacterDto
    {
        if (! $query instanceof GetCharacterQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetCharacterQuery::class]);
        }
        $character = $this->characterRepository->findById(id: $query->characterId);

        return $this->characterQueriesService->getCharacterDtoFromModel(character: $character);
    }
}
