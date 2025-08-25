<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Application\Queries\GetPlayableItemFieldQuery;

use App\PlayableItemFields\Domain\Dtos\PlayableItemFieldDto\PlayableItemFieldDto;
use App\PlayableItemFields\Domain\Services\PlayableItemFieldQueriesService;
use App\PlayableItemFields\Infrastructure\Repositories\PlayableItemFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetPlayableItemFieldQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private PlayableItemFieldQueriesService $playableItemFieldQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): PlayableItemFieldDto
    {
        if (! $query instanceof GetPlayableItemFieldQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetPlayableItemFieldQuery::class]);
        }
        $playableItemField = $this->playableItemFieldRepository->findById(id: $query->playableItemFieldId);

        return $this->playableItemFieldQueriesService->getPlayableItemFieldDtoFromModel(playableItemField: $playableItemField);
    }
}
