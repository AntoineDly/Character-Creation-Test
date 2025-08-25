<?php

declare(strict_types=1);

namespace App\Shared\Application\Queries;

use App\Shared\Domain\Dtos\DtoInterface;

interface QueryHandlerInterface
{
    public function handle(QueryInterface $query): DtoInterface;
}
