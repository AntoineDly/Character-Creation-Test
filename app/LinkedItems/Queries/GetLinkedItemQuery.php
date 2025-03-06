<?php

declare(strict_types=1);

namespace App\LinkedItems\Queries;

use App\LinkedItems\Dtos\LinkedItemDto;
use App\LinkedItems\Repositories\LinkedItemRepositoryInterface;
use App\LinkedItems\Services\LinkedItemQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetLinkedItemQuery implements QueryInterface
{
    public function __construct(
        private LinkedItemRepositoryInterface $linkedItemRepository,
        private LinkedItemQueriesService $linkedItemQueriesService,
        private string $linkedItemId,
    ) {
    }

    public function get(): LinkedItemDto
    {
        $linkedItem = $this->linkedItemRepository->findById(id: $this->linkedItemId);

        return $this->linkedItemQueriesService->getLinkedItemDtoFromModel(linkedItem: $linkedItem);
    }
}
