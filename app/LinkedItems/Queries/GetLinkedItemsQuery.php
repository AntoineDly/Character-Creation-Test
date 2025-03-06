<?php

declare(strict_types=1);

namespace App\LinkedItems\Queries;

use App\LinkedItems\Dtos\LinkedItemDto;
use App\LinkedItems\Repositories\LinkedItemRepositoryInterface;
use App\LinkedItems\Services\LinkedItemQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

final readonly class GetLinkedItemsQuery implements QueryInterface
{
    public function __construct(
        private LinkedItemRepositoryInterface $linkedItemRepository,
        private LinkedItemQueriesService $linkedItemQueriesService
    ) {
    }

    /** @return LinkedItemDto[] */
    public function get(): array
    {
        $linkedItems = $this->linkedItemRepository->index();

        return array_map(fn (?Model $linkedItem) => $this->linkedItemQueriesService->getLinkedItemDtoFromModel(linkedItem: $linkedItem), $linkedItems->all());
    }
}
