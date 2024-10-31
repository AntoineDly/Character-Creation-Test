<?php

declare(strict_types=1);

namespace App\Fields\Queries;

use App\Fields\Dtos\FieldDto;
use App\Fields\Repositories\FieldRepositoryInterface;
use App\Fields\Services\FieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetFieldQuery implements QueryInterface
{
    public function __construct(
        private FieldRepositoryInterface $fieldRepository,
        private FieldQueriesService $fieldQueriesService,
        private string $fieldId
    ) {
    }

    public function get(): FieldDto
    {
        $field = $this->fieldRepository->findById(id: $this->fieldId);

        return $this->fieldQueriesService->getFieldDtoFromModel(field: $field);
    }
}
