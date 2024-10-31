<?php

declare(strict_types=1);

namespace App\DefaultComponentFields\Queries;

use App\DefaultComponentFields\Dtos\DefaultComponentFieldDto;
use App\DefaultComponentFields\Repositories\DefaultComponentFieldRepositoryInterface;
use App\DefaultComponentFields\Services\DefaultComponentFieldQueriesService;
use App\Shared\Queries\QueryInterface;

final readonly class GetDefaultComponentFieldsQuery implements QueryInterface
{
    public function __construct(
        private DefaultComponentFieldRepositoryInterface $defaultComponentFieldRepository,
        private DefaultComponentFieldQueriesService $defaultComponentFieldQueriesService
    ) {
    }

    /** @return DefaultComponentFieldDto[] */
    public function get(): array
    {
        $defaultComponentFields = $this->defaultComponentFieldRepository->index();

        /** @var DefaultComponentFieldDto[] $defaultComponentFieldDtos */
        $defaultComponentFieldDtos = [];

        foreach ($defaultComponentFields as $defaultComponentField) {
            $defaultComponentFieldDtos[] = $this->defaultComponentFieldQueriesService->getDefaultComponentFieldDtoFromModel(defaultComponentField: $defaultComponentField);
        }

        return $defaultComponentFieldDtos;
    }
}
