<?php

declare(strict_types=1);

namespace App\Items\Repositories;

use App\Base\Exceptions\InvalidClassException;
use App\Base\Repositories\AbstractRepository\AbstractRepository;
use App\Items\Exceptions\ItemNotFoundException;
use App\Items\Models\Item;

final class ItemRepository extends AbstractRepository implements ItemRepositoryInterface
{
    public function __construct(Item $model)
    {
        parent::__construct($model);
    }

    public function associateGame(string $itemId, string $gameId): void
    {
        $item = $this->findById(id: $itemId);

        if (is_null($item)) {
            throw new ItemNotFoundException(message: 'Item not found', code: 404);
        }

        if (! $item instanceof Item) {
            throw new InvalidClassException(
                'Class was expected to be Item, '.get_class($item).' given.'
            );
        }

        $item->games()->attach($gameId);
    }

    public function associateCategory(string $itemId, string $categoryId): void
    {
        $item = $this->findById(id: $itemId);

        if (is_null($item)) {
            throw new ItemNotFoundException(message: 'Item not found', code: 404);
        }

        if (! $item instanceof Item) {
            throw new InvalidClassException(
                'Class was expected to be Item, '.get_class($item).' given.'
            );
        }

        $item->categories()->attach($categoryId);
    }

    public function associateCharacter(string $itemId, string $characterId): void
    {
        $item = $this->findById(id: $itemId);

        if (is_null($item)) {
            throw new ItemNotFoundException(message: 'Item not found', code: 404);
        }

        if (! $item instanceof Item) {
            throw new InvalidClassException(
                'Class was expected to be Item, '.get_class($item).' given.'
            );
        }

        $item->characters()->attach($characterId);
    }
}
