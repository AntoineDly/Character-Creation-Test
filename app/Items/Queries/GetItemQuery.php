<?php

declare(strict_types=1);

namespace App\Items\Queries;

use App\Base\Queries\QueryInterface;
use App\Items\Dtos\ItemDto;
use App\Items\Repositories\ItemRepositoryInterface;
use App\Items\Services\ItemQueriesService;

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
