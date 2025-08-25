<?php

declare(strict_types=1);

namespace App\Parameters\Infrastructure\Repositories;

use App\Parameters\Domain\Models\Parameter;
use App\Shared\Infrastructure\Repositories\RepositoryInterface;

/**
 * @extends RepositoryInterface<Parameter>
 */
interface ParameterRepositoryInterface extends RepositoryInterface
{
}
