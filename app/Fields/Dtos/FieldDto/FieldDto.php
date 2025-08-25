<?php

declare(strict_types=1);

namespace App\Fields\Dtos\FieldDto;

use App\Fields\Enums\TypeFieldEnum;
use App\Parameters\Domain\Enums\TypeParameterEnum;
use App\Shared\Domain\Dtos\DtoInterface;

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
