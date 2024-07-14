<?php

declare(strict_types=1);

namespace App\Base\Handlers;

use App\Base\Commands\CommandInterface;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): void;
}
