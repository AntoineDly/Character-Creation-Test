<?php

declare(strict_types=1);

namespace App\Shared\CommandBus;

use App\Shared\Commands\CommandInterface;
use App\Shared\Handlers\CommandHandlerInterface;
use App\Shared\Http\Exceptions\InvalidClassException;
use App\Shared\Http\Exceptions\IsNotObjectException;
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
            throw new IsNotObjectException(data: ['currentType' => gettype($handler)]);
        }

        if (! $handler instanceof CommandHandlerInterface) {
            throw new InvalidClassException(data: ['expectedImplementedInterface' => CommandHandlerInterface::class, 'currentClass' => $handler::class]);
        }

        $handler->handle($command);
    }

    private function resolveHandlerName(CommandInterface $command): string
    {
        $reflection = new ReflectionClass($command);
        $handlerName = "{$reflection->getShortName()}Handler";
        $namespaceName = $reflection->getNamespaceName();

        return "{$namespaceName}\\{$handlerName}";
    }
}
