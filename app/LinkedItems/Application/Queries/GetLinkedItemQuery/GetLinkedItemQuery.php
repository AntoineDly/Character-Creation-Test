<?php

declare(strict_types=1);

namespace App\LinkedItems\Application\Queries\GetLinkedItemQuery;

use App\LinkedItems\Domain\Dtos\LinkedItemDto\LinkedItemDto;
use App\LinkedItems\Domain\Services\LinkedItemQueriesService;
use App\LinkedItems\Infrastructure\Repositories\LinkedItemRepositoryInterface;
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
