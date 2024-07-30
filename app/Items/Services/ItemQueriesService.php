<?php

declare(strict_types=1);

namespace App\Items\Services;

use App\Base\Exceptions\InvalidClassException;
use App\Items\Builders\ItemDtoBuilder;
use App\Items\Dtos\ItemDto;
use App\Items\Exceptions\ItemNotFoundException;
use App\Items\Models\Item;
use Illuminate\Database\Eloquent\Model;

final readonly class ItemQueriesService
{
    public function __construct(
        private ItemDtoBuilder $itemDtoBuilder,
    ) {
    }

    public function getItemDtoFromModel(?Model $item): ItemDto
    {
        if (is_null($item)) {
            throw new ItemNotFoundException(message: 'Category not found', code: 404);
        }

        if (! $item instanceof Item) {
            throw new InvalidClassException(
                'Class was expected to be Item, '.get_class($item).' given.'
            );
        }

        /** @var array{'id': string, 'name': string} $itemData */
        $itemData = $item->toArray();

        return $this->itemDtoBuilder
            ->setId(id: $itemData['id'])
            ->setName(name: $itemData['name'])
            ->build();
    }
}
