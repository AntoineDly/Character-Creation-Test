<?php

declare(strict_types=1);

namespace App\Components\Application\Queries\GetComponentQuery;

use App\Components\Domain\Dtos\ComponentDto;
use App\Components\Domain\Services\ComponentQueriesService;
use App\Components\Infrastructure\Repositories\ComponentRepositoryInterface;
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
