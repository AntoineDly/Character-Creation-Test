<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Infrastructure\Repositories;

use App\Fields\Infrastructure\Repositories\FieldRepositoryInterface;
use App\LinkedItemFields\Domain\Models\LinkedItemField;

/**
 * @extends FieldRepositoryInterface<LinkedItemField>
 */
interface LinkedItemFieldRepositoryInterface extends FieldRepositoryInterface
{
}
