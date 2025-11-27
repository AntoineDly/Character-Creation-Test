<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Infrastructure\Repositories;

use App\Fields\Infrastructure\Repositories\FieldRepositoryInterface;
use App\PlayableItemFields\Domain\Models\PlayableItemField;

/**
 * @extends FieldRepositoryInterface<PlayableItemField>
 */
interface PlayableItemFieldRepositoryInterface extends FieldRepositoryInterface
{
}
