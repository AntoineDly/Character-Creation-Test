<?php

declare(strict_types=1);

namespace App\Items\Application\Queries\GetItemQuery;

use App\Items\Domain\Dtos\ItemDto;
use App\Items\Domain\Services\ItemQueriesService;
use App\Items\Infrastructure\Repositories\ItemRepositoryInterface;
use App\Shared\Queries\QueryInterface;

final readonly class GetItemQuery implements QueryInterface
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
        private ItemQueriesService $itemQueriesService,
        private string $itemId,
    ) {
    }

    public function get(): ItemDto
    {
        $item = $this->itemRepository->findById(id: $this->itemId);

        return $this->itemQueriesService->getItemDtoFromModel(item: $item);
    }
}
