<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Application\Queries\GetPlayableItemFieldQuery;

use App\PlayableItemFields\Domain\Dtos\PlayableItemFieldDto\PlayableItemFieldDto;
use App\PlayableItemFields\Domain\Services\PlayableItemFieldQueriesService;
use App\PlayableItemFields\Infrastructure\Repositories\PlayableItemFieldRepositoryInterface;
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
