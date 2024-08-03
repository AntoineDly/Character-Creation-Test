<?php

declare(strict_types=1);

namespace App\Shared\Handlers;

use App\Shared\Commands\CommandInterface;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): void;
}
