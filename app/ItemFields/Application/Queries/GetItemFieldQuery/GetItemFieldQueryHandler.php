<?php

declare(strict_types=1);

namespace App\ItemFields\Application\Queries\GetItemFieldQuery;

use App\Fields\Domain\Dtos\FieldDto\FieldDto;
use App\Fields\Domain\Services\FieldServices;
use App\ItemFields\Infrastructure\Repositories\ItemFieldRepositoryInterface;
use App\Shared\Application\Queries\IncorrectQueryException;
use App\Shared\Application\Queries\QueryHandlerInterface;
use App\Shared\Application\Queries\QueryInterface;

final readonly class GetItemFieldQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ItemFieldRepositoryInterface $itemFieldRepository,
        private FieldServices $fieldServices,
    ) {
    }

    public function handle(QueryInterface $query): FieldDto
    {
        if (! $query instanceof GetItemFieldQuery) {
            throw new IncorrectQueryException(data: ['handler' => self::class, 'currentQuery' => $query::class, 'expectedQuery' => GetItemFieldQuery::class]);
        }
        $itemField = $this->itemFieldRepository->findById(id: $query->itemFieldId);

        return $this->fieldServices->getFieldDtoFromFieldInterface($itemField);
    }
}
