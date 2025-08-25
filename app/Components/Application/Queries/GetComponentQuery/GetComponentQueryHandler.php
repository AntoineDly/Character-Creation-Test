<?php

namespace App\Components\Application\Queries\GetComponentQuery;

use App\Categories\Application\Commands\CreateCategoryCommand\CreateCategoryCommand;
use App\Categories\Application\Queries\GetAllCategoriesQuery\GetAllCategoriesQuery;
use App\Categories\Domain\Dtos\CategoryDto\CategoryDtoCollection;
use App\Categories\Domain\Models\Category;
use App\Categories\Domain\Services\CategoryQueriesService;
use App\Categories\Infrastructure\Repositories\CategoryRepositoryInterface;
use App\Characters\Application\Queries\GetCharacterQuery\GetCharacterQuery;
use App\Characters\Application\Queries\GetCharacterWithGameQuery\GetCharacterWithGameQuery;
use App\Characters\Application\Queries\GetCharacterWithLinkedItemsQuery\GetCharacterWithLinkedItemsQuery;
use App\Characters\Domain\Dtos\CharacterWithGameDto\CharacterWithGameDto;
use App\Characters\Domain\Dtos\CharacterWithLinkedItemsDto\CharacterWithLinkedItemsDto;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\ComponentFields\Application\Queries\GetComponentFieldQuery\GetComponentFieldQuery;
use App\ComponentFields\Domain\Services\ComponentFieldQueriesService;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Components\Domain\Dtos\ComponentDto\ComponentDto;
use App\Components\Domain\Services\ComponentQueriesService;
use App\Components\Infrastructure\Repositories\ComponentRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;
use App\Shared\Domain\Dtos\DtoInterface;
use App\Characters\Domain\Dtos\CharacterDto\CharacterDto;
use App\ComponentFields\Domain\Dtos\ComponentFieldDto\ComponentFieldDto;

final readonly class GetComponentQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ComponentRepositoryInterface $componentRepository,
        private ComponentQueriesService $componentQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): ComponentDto
    {
        if (! $query instanceof GetComponentQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetComponentQuery::class]);
        }
        $component = $this->componentRepository->findById($query->componentId);

        return $this->componentQueriesService->getComponentDtoFromModel(component: $component);
    }
}
