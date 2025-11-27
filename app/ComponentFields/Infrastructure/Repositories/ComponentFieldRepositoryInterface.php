<?php

declare(strict_types=1);

namespace App\ComponentFields\Infrastructure\Repositories;

use App\ComponentFields\Domain\Models\ComponentField;
use App\Fields\Infrastructure\Repositories\FieldRepositoryInterface;

/**
 * @extends FieldRepositoryInterface<ComponentField>
 */
interface ComponentFieldRepositoryInterface extends FieldRepositoryInterface
{
}
