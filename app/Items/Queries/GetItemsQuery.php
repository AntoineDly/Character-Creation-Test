<?php

declare(strict_types=1);

namespace App\Items\Queries;

use App\Base\Queries\QueryInterface;
use App\Items\Dtos\ItemDto;
use App\Items\Repositories\ItemRepositoryInterface;
use App\Items\Services\ItemQueriesService;

final readonly class GetItemsQuery implements QueryInterface
{
    public function __construct(
        private ItemRepositoryInterface $itemRepository,
        private ItemQueriesService $itemQueriesService
    ) {
    }

    /** @return ItemDto[] */
    public function get(): array
    {
        $items = $this->itemRepository->index();

        /** @var ItemDto[] $itemsDtos */
        $itemsDtos = [];

        foreach ($items as $item) {
            $itemsDtos[] = $this->itemQueriesService->getItemDtoFromModel(item: $item);
        }

        return $itemsDtos;
    }
}
