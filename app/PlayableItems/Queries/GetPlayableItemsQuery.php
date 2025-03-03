<?php

declare(strict_types=1);

namespace App\PlayableItems\Queries;

use App\PlayableItems\Dtos\PlayableItemDto;
use App\PlayableItems\Repositories\PlayableItemRepositoryInterface;
use App\PlayableItems\Services\PlayableItemQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

final readonly class GetPlayableItemsQuery implements QueryInterface
{
    public function __construct(
        private PlayableItemRepositoryInterface $playableItemRepository,
        private PlayableItemQueriesService $playableItemQueriesService
    ) {
    }

    /** @return PlayableItemDto[] */
    public function get(): array
    {
        $playableItems = $this->playableItemRepository->index();

        return array_map(fn (?Model $playableItem) => $this->playableItemQueriesService->getPlayableItemDtoFromModel(playableItem: $playableItem), $playableItems->all());
    }
}
