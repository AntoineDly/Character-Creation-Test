<?php

declare(strict_types=1);

namespace App\Items\Application\Queries\GetItemQuery;

use App\Items\Domain\Dtos\ItemDto\ItemDto;
use App\Items\Domain\Services\ItemQueriesService;
use App\Items\Infrastructure\Repositories\ItemRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetItemQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
        private ItemQueriesService $itemQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): ItemDto
    {
        if (! $query instanceof GetItemQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetItemQuery::class]);
        }
        $item = $this->itemRepository->findById(id: $query->itemId);

        return $this->itemQueriesService->getItemDtoFromModel(item: $item);
    }
}
