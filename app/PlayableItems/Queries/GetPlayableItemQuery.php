<?php

declare(strict_types=1);

namespace App\PlayableItems\Queries;

use App\PlayableItems\Dtos\PlayableItemDto;
use App\PlayableItems\Repositories\PlayableItemRepositoryInterface;
use App\PlayableItems\Services\PlayableItemQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetPlayableItemQuery implements QueryInterface
{
    public function __construct(
        private PlayableItemRepositoryInterface $playableItemRepository,
        private PlayableItemQueriesService $playableItemQueriesService,
        private string $playableItemId,
    ) {
    }

    public function get(): PlayableItemDto
    {
        $playableItem = $this->playableItemRepository->findById(id: $this->playableItemId);

        return $this->playableItemQueriesService->getPlayableItemDtoFromModel(playableItem: $playableItem);
    }
}
