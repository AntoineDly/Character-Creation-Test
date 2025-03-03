<?php

declare(strict_types=1);

namespace App\ComponentFields\Queries;

use App\ComponentFields\Dtos\ComponentFieldDto;
use App\ComponentFields\Repositories\ComponentFieldRepositoryInterface;
use App\ComponentFields\Services\ComponentFieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetComponentFieldQuery implements QueryInterface
{
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ComponentFieldQueriesService $componentFieldQueriesService,
        private string $componentFieldId
    ) {
    }

    public function get(): ComponentFieldDto
    {
        $componentField = $this->componentFieldRepository->findById(id: $this->componentFieldId);

        return $this->componentFieldQueriesService->getComponentFieldDtoFromModel(componentField: $componentField);
    }
}
