<?php

declare(strict_types=1);

namespace App\Characters\Application\Queries\GetCharacterQuery;

use App\Characters\Domain\Dtos\CharacterDto\CharacterDto;
use App\Characters\Domain\Services\CharacterQueriesService;
use App\Characters\Infrastructure\Repositories\CharacterRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

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
