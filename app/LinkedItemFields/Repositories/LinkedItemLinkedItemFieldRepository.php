<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Repositories;

use App\LinkedItemFields\Models\LinkedItemField;
use App\Shared\Repositories\AbstractRepository\AbstractRepository;

final readonly class LinkedItemLinkedItemFieldRepository extends AbstractRepository implements LinkedItemFieldRepositoryInterface
{
    public function __construct(LinkedItemField $model)
    {
        parent::__construct($model);
    }
}
