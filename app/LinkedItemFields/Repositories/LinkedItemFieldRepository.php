<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Repositories;

use App\LinkedItemFields\Models\LinkedItemField;
use App\Shared\Repositories\RepositoryTrait;

final readonly class LinkedItemFieldRepository implements LinkedItemFieldRepositoryInterface
{
    use RepositoryTrait;

    public function __construct(LinkedItemField $model)
    {
        $this->model = $model;
    }
}
