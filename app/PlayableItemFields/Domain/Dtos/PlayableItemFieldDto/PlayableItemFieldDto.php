<?php

declare(strict_types=1);

namespace App\PlayableItemFields\Domain\Dtos\PlayableItemFieldDto;

use App\Shared\Dtos\DtoInterface;

final readonly class PlayableItemFieldDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $value,
    ) {
    }
}
