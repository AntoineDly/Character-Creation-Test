<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Application\Queries\GetLinkedItemFieldQuery;

use App\LinkedItemFields\Domain\Dtos\LinkedItemFieldDto;
use App\LinkedItemFields\Domain\Services\LinkedItemFieldQueriesService;
use App\LinkedItemFields\Infrastructure\Repositories\LinkedItemFieldRepositoryInterface;
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
