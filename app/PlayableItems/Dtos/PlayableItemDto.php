<?php

declare(strict_types=1);

namespace App\PlayableItems\Dtos;

use App\Shared\Dtos\DtoInterface;

final readonly class PlayableItemDto implements DtoInterface
{
    public function __construct(
        public string $id,
    ) {
    }
}
