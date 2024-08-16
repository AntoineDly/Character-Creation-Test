<?php

declare(strict_types=1);

namespace App\Components\Queries;

use App\Components\Dtos\ComponentDto;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\Components\Services\ComponentQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetComponentQuery implements QueryInterface
{
    public function __construct(
        private ComponentRepositoryInterface $componentRepository,
        private ComponentQueriesService $componentQueriesService,
        private string $componentId,
    ) {
    }

    public function get(): ComponentDto
    {
        $component = $this->componentRepository->findById(id: $this->componentId);

        return $this->componentQueriesService->getComponentDtoFromModel(component: $component);
    }
}
