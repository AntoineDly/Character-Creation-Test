<?php

declare(strict_types=1);

namespace App\Shared\Fields\Dtos;

use App\Parameters\Enums\TypeParameterEnum;
use App\Shared\Dtos\DtoInterface;
use App\Shared\Enums\TypeFieldEnum;

final readonly class FieldDto implements DtoInterface
{
    public function __construct(
        public string $id,
        public string $parameterId,
        public string $name,
        public string $value,
        public TypeParameterEnum $typeParameterEnum,
        public TypeFieldEnum $typeFieldEnum,
    ) {
    }
}
