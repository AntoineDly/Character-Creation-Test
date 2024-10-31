<?php

declare(strict_types=1);

namespace App\Fields\Queries;

use App\Fields\Dtos\FieldDto;
use App\Fields\Repositories\FieldRepositoryInterface;
use App\Fields\Services\FieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetFieldsQuery implements QueryInterface
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
        private FieldQueriesService $fieldQueriesService
    ) {
    }

    /** @return FieldDto[] */
    public function get(): array
    {
        $fields = $this->fieldRepository->index();

        /** @var FieldDto[] $fieldDtos */
        $fieldDtos = [];

        foreach ($fields as $field) {
            $fieldDtos[] = $this->fieldQueriesService->getFieldDtoFromModel(field: $field);
        }

        return $fieldDtos;
    }
}
