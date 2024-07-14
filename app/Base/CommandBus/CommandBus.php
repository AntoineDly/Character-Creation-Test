<?php

declare(strict_types=1);

namespace App\Base\CommandBus;

use App\Base\Commands\CommandInterface;
use App\Base\Exceptions\ClassIsNotCommandHandlerException;
use App\Base\Exceptions\IsNotObjectException;
use App\Base\Handlers\CommandHandlerInterface;
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
                'Handler was expected to be an object : '.gettype($handler).'given.'
            );
        }

        if (! $handler instanceof CommandHandlerInterface) {
            throw new ClassIsNotCommandHandlerException(
                'Handler was expected to implement command handler interface, '.get_class($handler).'given.'
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
