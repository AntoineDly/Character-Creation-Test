<?php

declare(strict_types=1);

namespace App\LinkedItemFields\Application\Queries\GetLinkedItemFieldQuery;

use App\Fields\Domain\Dtos\FieldDto\FieldDto;
use App\Fields\Domain\Services\FieldServices;
use App\LinkedItemFields\Infrastructure\Repositories\LinkedItemFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetLinkedItemFieldQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private LinkedItemFieldRepositoryInterface $linkedItemFieldRepository,
        private FieldServices $fieldServices,
    ) {
    }

    public function handle(QueryInterface $query): FieldDto
    {
        if (! $query instanceof GetLinkedItemFieldQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetLinkedItemFieldQuery::class]);
        }
        $linkedItemField = $this->linkedItemFieldRepository->findById(id: $query->linkedItemFieldId);

        return $this->fieldServices->getFieldDtoFromFieldInterface($linkedItemField);
    }
}
