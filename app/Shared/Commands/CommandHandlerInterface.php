<?php

declare(strict_types=1);

namespace App\Shared\Commands;

interface CommandHandlerInterface
{
    public function handle(CommandInterface $command): void;
}
