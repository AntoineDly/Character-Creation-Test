<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterWithGameQuery;

use App\Characters\Domain\Dtos\CharacterWithGameDto\CharacterWithGameDto;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetCharacterWithGameQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CharacterRepositoryInterface $characterRepository,
        private CharacterQueriesService $characterQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): CharacterWithGameDto
    {
        if (! $query instanceof GetCharacterWithGameQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetCharacterWithGameQuery::class]);
        }
        $character = $this->characterRepository->getCharacterWithGameById($query->characterId);

        return $this->characterQueriesService->getCharacterWithGameDtoFromModel(character: $character);
    }
}
