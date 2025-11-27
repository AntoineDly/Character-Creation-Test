<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Repositories;

use App\Fields\Infrastructure\Repositories\FieldRepositoryTrait;
use App\LinkedItemFields\Domain\Models\LinkedItemField;

final readonly class LinkedItemFieldRepository implements LinkedItemFieldRepositoryInterface
{
    /** @use FieldRepositoryTrait<LinkedItemField> */
    use FieldRepositoryTrait;

    public function __construct(LinkedItemField $model)
    {
        $this->model = $model;
    }
}
