<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterWithLinkedItemsQuery;

use App\Characters\Domain\Dtos\CharacterWithLinkedItemsDto\CharacterWithLinkedItemsDto;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetCharacterWithLinkedItemsQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): CharacterWithLinkedItemsDto
    {
        if (! $query instanceof GetCharacterWithLinkedItemsQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetCharacterWithLinkedItemsQuery::class]);
        }
        $character = $this->characterRepository->getCharacterWithLinkedItemsById($query->characterId);

        return $this->characterQueriesService->getCharacterWithLinkedItemsDtoFromModel(character: $character);
    }
}
