<?php

declare(strict_types=1);

namespace App\Shared\Enums;

enum TypeFieldEnum: string
{
    case LINKED_ITEM_FIELD = 'linked_item_field';
    case PLAYABLE_ITEM_FIELD = 'playable_item_field';
    case ITEM_FIELD = 'item_field';
    case COMPONENT_FIELD = 'component_field';

    public function weight(): int
    {
        return match ($this) {
            self::LINKED_ITEM_FIELD => 4,
            self::PLAYABLE_ITEM_FIELD => 3,
            self::ITEM_FIELD => 2,
            self::COMPONENT_FIELD => 1,
        };
    }
}
