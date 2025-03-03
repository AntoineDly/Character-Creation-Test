<?php

declare(strict_types=1);

namespace App\Items\Queries;

use App\Items\Dtos\ItemDto;
use App\Items\Repositories\ItemRepositoryInterface;
use App\Items\Services\ItemQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

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

        return array_map(fn (?Model $item) => $this->itemQueriesService->getItemDtoFromModel(item: $item), $items->all());
    }
}
