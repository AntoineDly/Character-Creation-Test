<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Queries;

use App\LinkedItemFields\Dtos\LinkedItemFieldDto;
use App\LinkedItemFields\Repositories\LinkedItemFieldRepositoryInterface;
use App\LinkedItemFields\Services\LinkedItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetLinkedItemFieldQuery implements QueryInterface
{
    public function __construct(
        private LinkedItemFieldRepositoryInterface $linkedItemFieldRepository,
        private LinkedItemFieldQueriesService $linkedItemFieldQueriesService,
        private string $linkedItemFieldId
    ) {
    }

    public function get(): LinkedItemFieldDto
    {
        $linkedItemField = $this->linkedItemFieldRepository->findById(id: $this->linkedItemFieldId);

        return $this->linkedItemFieldQueriesService->getLinkedFieldDtoFromModel(linkedItemField: $linkedItemField);
    }
}
