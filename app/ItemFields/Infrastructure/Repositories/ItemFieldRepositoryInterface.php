<?php

declare(strict_types=1);

namespace App\ItemFields\Infrastructure\Repositories;

use App\Fields\Infrastructure\Repositories\FieldRepositoryInterface;
use App\ItemFields\Domain\Models\ItemField;

/**
 * @extends FieldRepositoryInterface<ItemField>
 */
interface ItemFieldRepositoryInterface extends FieldRepositoryInterface
{
}
