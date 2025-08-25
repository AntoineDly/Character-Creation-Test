<?php

declare(strict_types=1);

namespace App\Components\Application\Queries\GetComponentQuery;

use App\Components\Domain\Dtos\ComponentDto\ComponentDto;
use App\Components\Domain\Services\ComponentQueriesService;
use App\Components\Infrastructure\Repositories\ComponentRepositoryInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetComponentQuery implements QueryInterface
{
    public function __construct(
        public string $componentId,
    ) {
    }
}
