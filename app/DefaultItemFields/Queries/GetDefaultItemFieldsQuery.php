<?php

declare(strict_types=1);

namespace App\DefaultItemFields\Queries;

use App\DefaultItemFields\Dtos\DefaultItemFieldDto;
use App\DefaultItemFields\Repositories\DefaultItemFieldRepositoryInterface;
use App\DefaultItemFields\Services\DefaultItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetDefaultItemFieldsQuery implements QueryInterface
{
    public function __construct(
        private DefaultItemFieldRepositoryInterface $defaultItemFieldRepository,
        private DefaultItemFieldQueriesService $defaultItemFieldQueriesService
    ) {
    }

    /** @return DefaultItemFieldDto[] */
    public function get(): array
    {
        $defaultItemFields = $this->defaultItemFieldRepository->index();

        /** @var DefaultItemFieldDto[] $defaultItemFieldDtos */
        $defaultItemFieldDtos = [];

        foreach ($defaultItemFields as $defaultItemField) {
            $defaultItemFieldDtos[] = $this->defaultItemFieldQueriesService->getDefaultItemFieldDtoFromModel(defaultItemField: $defaultItemField);
        }

        return $defaultItemFieldDtos;
    }
}
