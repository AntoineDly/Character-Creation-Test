<?php

declare(strict_types=1);

namespace App\PlayableItems\Application\Queries\GetPlayableItemQuery;

use App\PlayableItems\Domain\Dtos\PlayableItemDto\PlayableItemDto;
use App\PlayableItems\Domain\Services\PlayableItemQueriesService;
use App\PlayableItems\Infrastructure\Repositories\PlayableItemRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;

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
