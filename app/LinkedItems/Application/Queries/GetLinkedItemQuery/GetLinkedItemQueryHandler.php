<?php

declare(strict_types=1);

namespace App\LinkedItems\Application\Queries\GetLinkedItemQuery;

use App\LinkedItems\Domain\Dtos\LinkedItemDto\LinkedItemDto;
use App\LinkedItems\Domain\Services\LinkedItemQueriesService;
use App\LinkedItems\Infrastructure\Repositories\LinkedItemRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetLinkedItemQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LinkedItemRepositoryInterface $linkedItemRepository,
        private LinkedItemQueriesService $linkedItemQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): LinkedItemDto
    {
        if (! $query instanceof GetLinkedItemQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetLinkedItemQuery::class]);
        }
        $linkedItem = $this->linkedItemRepository->findById(id: $this->linkedItemId);

        return $this->linkedItemQueriesService->getLinkedItemDtoFromModel(linkedItem: $linkedItem);
    }
}
