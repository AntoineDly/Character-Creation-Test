<?php

declare(strict_types=1);

namespace App\Shared\Enums;

enum TypeFieldEnum: string
{
    case FIELD = 'field';
    case DEFAULT_ITEM_FIELD = 'default_item_field';
    case DEFAULT_COMPONENT_FIELD = 'default_component_field';

    public function weight(): int
    {
        return match ($this) {
            self::FIELD => 3,
            self::DEFAULT_ITEM_FIELD => 2,
            self::DEFAULT_COMPONENT_FIELD => 1,
        };
    }
}
