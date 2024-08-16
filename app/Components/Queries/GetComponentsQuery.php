<?php

declare(strict_types=1);

namespace App\Components\Queries;

use App\Components\Dtos\ComponentDto;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\Components\Services\ComponentQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetComponentsQuery implements QueryInterface
{
    public function __construct(
        private ComponentRepositoryInterface $componentRepository,
        private ComponentQueriesService $componentQueriesService
    ) {
    }

    /** @return ComponentDto[] */
    public function get(): array
    {
        $components = $this->componentRepository->index();

        /** @var ComponentDto[] $componentsDtos */
        $componentsDtos = [];

        foreach ($components as $component) {
            $componentsDtos[] = $this->componentQueriesService->getComponentDtoFromModel(component: $component);
        }

        return $componentsDtos;
    }
}
