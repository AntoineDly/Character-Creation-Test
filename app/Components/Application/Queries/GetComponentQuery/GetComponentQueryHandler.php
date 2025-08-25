<?php

declare(strict_types=1);

namespace App\Components\Application\Queries\GetComponentQuery;

use App\Components\Domain\Dtos\ComponentDto\ComponentDto;
use App\Components\Domain\Services\ComponentQueriesService;
use App\Components\Infrastructure\Repositories\ComponentRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetComponentQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ComponentRepositoryInterface $componentRepository,
        private ComponentQueriesService $componentQueriesService,
    ) {
    }

    public function handle(QueryInterface $query): ComponentDto
    {
        if (! $query instanceof GetComponentQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetComponentQuery::class]);
        }
        $component = $this->componentRepository->findById($query->componentId);

        return $this->componentQueriesService->getComponentDtoFromModel(component: $component);
    }
}
