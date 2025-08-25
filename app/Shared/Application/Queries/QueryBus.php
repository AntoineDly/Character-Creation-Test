<?php

declare(strict_types=1);

namespace App\Shared\Application\Queries;

use App\Shared\Domain\Dtos\DtoInterface;
use App\Shared\Infrastructure\Http\Exceptions\InvalidClassException;
use App\Shared\Infrastructure\Http\Exceptions\IsNotObjectException;
use Psr\Container\ContainerInterface;
use ReflectionClass;

final readonly class QueryBus
{
    public function __construct(
        private ContainerInterface $container,
    ) {
    }

    public function dispatch(QueryInterface $query): DtoInterface
    {
        $handlerName = $this->resolveHandlerName($query);
        $handler = $this->container->get($handlerName);

        if (! is_object($handler)) {
            throw new IsNotObjectException(data: ['currentType' => gettype($handler)]);
        }

        if (! $handler instanceof QueryHandlerInterface) {
            throw new InvalidClassException(data: ['expectedImplementedInterface' => QueryHandlerInterface::class, 'currentClass' => $handler::class]);
        }

        return $handler->handle($query);
    }

    private function resolveHandlerName(QueryInterface $query): string
    {
        $reflection = new ReflectionClass($query);
        $handlerName = "{$reflection->getShortName()}Handler";
        $namespaceName = $reflection->getNamespaceName();

        return "{$namespaceName}\\{$handlerName}";
    }
}
