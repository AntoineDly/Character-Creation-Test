<?php

declare(strict_types=1);

namespace App\ItemFields\Queries;

use App\ItemFields\Dtos\ItemFieldDto;
use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\ItemFields\Services\ItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetItemFieldQuery implements QueryInterface
{
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private ItemFieldQueriesService $itemFieldQueriesService,
        private string $itemFieldId
    ) {
    }

    public function get(): ItemFieldDto
    {
        $itemField = $this->itemFieldRepository->findById(id: $this->itemFieldId);

        return $this->itemFieldQueriesService->getItemFieldDtoFromModel(itemField: $itemField);
    }
}
