<?php

declare(strict_types=1);

namespace App\Shared\Http\Exceptions;

use App\Shared\Http\Enums\HttpStatusEnum;
use Throwable;

interface HttpExceptionInterface extends Throwable
{
    public function getStatus(): HttpStatusEnum;

    /** @return string[] */
    public function getData(): array;
}
