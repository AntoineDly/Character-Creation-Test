<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Queries;

use App\PlayableItemFields\Dtos\PlayableItemFieldDto;
use App\PlayableItemFields\Repositories\PlayableItemFieldRepositoryInterface;
use App\PlayableItemFields\Services\PlayableItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

final readonly class GetPlayableItemFieldsQuery implements QueryInterface
{
    public function __construct(
        private PlayableItemFieldRepositoryInterface $playableItemFieldRepository,
        private PlayableItemFieldQueriesService $playableItemFieldQueriesService
    ) {
    }

    /** @return PlayableItemFieldDto[] */
    public function get(): array
    {
        $playableItemFields = $this->playableItemFieldRepository->index();

        return array_map(fn (?Model $playableItemField) => $this->playableItemFieldQueriesService->getPlayableItemFieldDtoFromModel(playableItemField: $playableItemField), $playableItemFields->all());
    }
}
