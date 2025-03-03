<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Queries;

use App\LinkedItemFields\Dtos\LinkedItemFieldDto;
use App\LinkedItemFields\Repositories\LinkedItemFieldRepositoryInterface;
use App\LinkedItemFields\Services\LinkedItemFieldQueriesService;
use App\Shared\Queries\QueryInterface;
use Illuminate\Database\Eloquent\Model;

final readonly class GetLinkedItemFieldsQuery implements QueryInterface
{
    public function __construct(
        private LinkedItemFieldRepositoryInterface $linkedItemFieldRepository,
        private LinkedItemFieldQueriesService $linkedItemFieldQueriesService,
    ) {
    }

    /** @return LinkedItemFieldDto[] */
    public function get(): array
    {
        $fields = $this->linkedItemFieldRepository->index();

        return array_map(fn (?Model $linkedItemField) => $this->linkedItemFieldQueriesService->getLinkedFieldDtoFromModel(linkedItemField: $linkedItemField), $fields->all());
    }
}
