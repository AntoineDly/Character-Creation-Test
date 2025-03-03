<?php

declare(strict_types=1);

namespace App\ComponentFields\Queries;

use App\ComponentFields\Dtos\ComponentFieldDto;
use App\ComponentFields\Repositories\ComponentFieldRepositoryInterface;
use App\ComponentFields\Services\ComponentFieldQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

final readonly class GetComponentFieldsQuery implements QueryInterface
{
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ComponentFieldQueriesService $componentFieldQueriesService
    ) {
    }

    /** @return ComponentFieldDto[] */
    public function get(): array
    {
        $componentFields = $this->componentFieldRepository->index();

        return array_map(fn (?Model $componentField) => $this->componentFieldQueriesService->getComponentFieldDtoFromModel(componentField: $componentField), $componentFields->all());
    }
}
