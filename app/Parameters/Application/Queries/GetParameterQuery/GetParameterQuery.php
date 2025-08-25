<?php

declare(strict_types=1);

namespace App\Parameters\Application\Queries\GetParameterQuery;

use App\Shared\Application\Queries\QueryInterface;

final readonly class GetParameterQuery implements QueryInterface
{
    public function __construct(
        public string $parameterId,
    ) {
    }
}
