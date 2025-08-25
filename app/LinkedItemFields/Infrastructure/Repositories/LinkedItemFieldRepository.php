<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Repositories;

use App\LinkedItemFields\Domain\Models\LinkedItemField;
use App\Shared\Infrastructure\Repositories\RepositoryTrait;

final readonly class LinkedItemFieldRepository implements LinkedItemFieldRepositoryInterface
{
    /** @use RepositoryTrait<LinkedItemField> */
    use RepositoryTrait;

    public function __construct(LinkedItemField $model)
    {
        $this->model = $model;
    }
}
