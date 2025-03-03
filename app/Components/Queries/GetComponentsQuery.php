<?php

declare(strict_types=1);

namespace App\Components\Queries;

use App\Components\Dtos\ComponentDto;
use App\Components\Repositories\ComponentRepositoryInterface;
use App\Components\Services\ComponentQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

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

        return array_map(fn (?Model $component) => $this->componentQueriesService->getComponentDtoFromModel(component: $component), $components->all());
    }
}
