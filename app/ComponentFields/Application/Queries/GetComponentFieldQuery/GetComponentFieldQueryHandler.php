<?php

declare(strict_types=1);

namespace App\ComponentFields\Application\Queries\GetComponentFieldQuery;

use App\ComponentFields\Infrastructure\Repositories\ComponentFieldRepositoryInterface;
use App\Fields\Domain\Dtos\FieldDto\FieldDto;
use App\Fields\Domain\Services\FieldServices;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetComponentFieldQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ComponentFieldRepositoryInterface $componentFieldRepository,
        private FieldServices $fieldServices,
    ) {
    }

    public function handle(QueryInterface $query): FieldDto
    {
        if (! $query instanceof GetComponentFieldQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetComponentFieldQuery::class]);
        }
        $componentField = $this->componentFieldRepository->findByIdWithParameters($query->componentFieldId);

        return $this->fieldServices->getFieldDtoFromFieldInterface($componentField);
    }
}
