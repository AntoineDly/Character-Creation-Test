<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Queries;

use App\DefaultItemFields\Dtos\DefaultItemFieldDto;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepositoryInterface;
use App\DefaultItemFields\Services\DefaultItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetDefaultItemFieldQuery implements QueryInterface
{
    public function __construct(
        private DefaultItemFieldRepositoryInterface $defaultItemFieldRepository,
        private DefaultItemFieldQueriesService $defaultItemFieldQueriesService,
        private string $defaultItemFieldId
    ) {
    }

    public function get(): DefaultItemFieldDto
    {
        $defaultItemField = $this->defaultItemFieldRepository->findById(id: $this->defaultItemFieldId);

        return $this->defaultItemFieldQueriesService->getDefaultItemFieldDtoFromModel(defaultItemField: $defaultItemField);
    }
}
