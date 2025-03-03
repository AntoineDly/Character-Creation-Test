<?php

declare(strict_types=1);

namespace App\ItemFields\Queries;

use App\ItemFields\Dtos\ItemFieldDto;
use App\ItemFields\Repositories\ItemFieldRepositoryInterface;
use App\ItemFields\Services\ItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

final readonly class GetItemFieldsQuery implements QueryInterface
{
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private ItemFieldQueriesService $itemFieldQueriesService
    ) {
    }

    /** @return ItemFieldDto[] */
    public function get(): array
    {
        $itemFields = $this->itemFieldRepository->index();

        return array_map(fn (?Model $itemField) => $this->itemFieldQueriesService->getItemFieldDtoFromModel(itemField: $itemField), $itemFields->all());
    }
}
