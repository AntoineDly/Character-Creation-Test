<?php

declare(strict_types=1);

namespace App\Shared\Fields\Enums;

enum TypeFieldEnum: int
{
    case LINKED_ITEM_FIELD = 4;
    case PLAYABLE_ITEM_FIELD = 3;
    case ITEM_FIELD = 2;
    case COMPONENT_FIELD = 1;

    public function getValueName(): string
    {
        return strtolower($this->name);
    }
}
