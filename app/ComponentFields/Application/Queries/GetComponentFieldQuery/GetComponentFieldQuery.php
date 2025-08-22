<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Queries\GetComponentFieldQuery;

use App\ComponentFields\Domain\Dtos\ComponentFieldDto\ComponentFieldDto;
use App\ComponentFields\Domain\Services\ComponentFieldQueriesService;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
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
