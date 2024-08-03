<?php

declare(strict_types=1);

namespace App\Shared\CommandBus;

use App\Shared\Commands\CommandInterface;
use App\Shared\Exceptions\InvalidClassException;
use App\Shared\Exceptions\IsNotObjectException;
use App\Shared\Handlers\CommandHandlerInterface;
use Psr\Container\ContainerInterface;
use ReflectionClass;

final readonly class CommandBus
{
    public function __construct(
        private ContainerInterface $container,
    ) {
    }

    public function handle(CommandInterface $command): void
    {
        $handlerName = $this->resolveHandlerName($command);
        $handler = $this->container->get($handlerName);

        if (! is_object($handler)) {
            throw new IsNotObjectException(
                'Handler was expected to be an object : '.gettype($handler).' given.'
            );
        }

        if (! $handler instanceof CommandHandlerInterface) {
            throw new InvalidClassException(
                'Class was expected to implement CommandHandlerInterface, '.get_class($handler).' given.'
            );
        }

        $handler->handle($command);
    }

    private function resolveHandlerName(CommandInterface $command): string
    {
        $reflection = new ReflectionClass($command);
        $handlerName = str_replace('Command', 'Handler', $reflection->getShortName());
        $namespaceName = str_replace('Commands', 'Handlers', $reflection->getNamespaceName());

        return $namespaceName.'\\'.$handlerName;
    }
}
