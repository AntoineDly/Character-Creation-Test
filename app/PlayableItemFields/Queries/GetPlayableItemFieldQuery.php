<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Queries;

use App\PlayableItemFields\Dtos\PlayableItemFieldDto;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\PlayableItemFields\Services\PlayableItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetPlayableItemFieldQuery implements QueryInterface
{
    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private PlayableItemFieldQueriesService $playableItemFieldQueriesService,
        private string $playableItemFieldId
    ) {
    }

    public function get(): PlayableItemFieldDto
    {
        $playableItemField = $this->playableItemFieldRepository->findById(id: $this->playableItemFieldId);

        return $this->playableItemFieldQueriesService->getPlayableItemFieldDtoFromModel(playableItemField: $playableItemField);
    }
}
