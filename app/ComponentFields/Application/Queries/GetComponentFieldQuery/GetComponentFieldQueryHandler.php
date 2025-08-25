<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Queries\GetComponentFieldQuery;

use App\ComponentFields\Domain\Dtos\ComponentFieldDto\ComponentFieldDto;
use App\ComponentFields\Domain\Services\ComponentFieldQueriesService;
use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetComponentFieldQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private ComponentFieldQueriesService $componentFieldQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): ComponentFieldDto
    {
        if (! $query instanceof GetComponentFieldQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetComponentFieldQuery::class]);
        }
        $componentField = $this->componentFieldRepository->findById($query->componentFieldId);

        return $this->componentFieldQueriesService->getComponentFieldDtoFromModel($componentField);
    }
}
