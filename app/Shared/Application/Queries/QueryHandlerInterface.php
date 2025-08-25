<?php

namespace App\Shared\Application\Queries;

use App\Shared\Domain\Dtos\DtoInterface;

interface QueryHandlerInterface
{
    public function handle(QueryInterface $query): DtoInterface;
}
