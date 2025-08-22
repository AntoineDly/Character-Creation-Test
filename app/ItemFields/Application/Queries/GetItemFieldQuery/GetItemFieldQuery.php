<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Queries\GetItemFieldQuery;

use App\ItemFields\Domain\Dtos\ItemFieldDto\ItemFieldDto;
use App\ItemFields\Domain\Services\ItemFieldQueriesService;
use App\ItemFields\Infrastructure\Repositories\ItemFieldRepositoryInterface;
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
