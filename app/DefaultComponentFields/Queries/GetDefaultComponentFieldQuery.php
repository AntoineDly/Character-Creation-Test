<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Queries;

use App\DefaultComponentFields\Dtos\DefaultComponentFieldDto;
use App\DefaultComponentFields\Repositories\DefaultComponentFieldRepositoryInterface;
use App\DefaultComponentFields\Services\DefaultComponentFieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetDefaultComponentFieldQuery implements QueryInterface
{
    public function __construct(
        private DefaultComponentFieldRepositoryInterface $defaultComponentFieldRepository,
        private DefaultComponentFieldQueriesService $defaultComponentFieldQueriesService,
        private string $defaultComponentFieldId
    ) {
    }

    public function get(): DefaultComponentFieldDto
    {
        $defaultComponentField = $this->defaultComponentFieldRepository->findById(id: $this->defaultComponentFieldId);

        return $this->defaultComponentFieldQueriesService->getDefaultComponentFieldDtoFromModel(defaultComponentField: $defaultComponentField);
    }
}
