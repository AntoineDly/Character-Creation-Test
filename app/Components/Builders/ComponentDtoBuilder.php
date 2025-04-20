<?php

declare(strict_types=1);

namespace App\Components\Builders;

use App\Components\Dtos\ComponentDto;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Http\Exceptions\NotAValidUuidException;

final class ComponentDtoBuilder implements BuilderInterface
{
    private string $id = '';

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function build(): ComponentDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        $componentDto = new ComponentDto(
            id: $this->id
        );

        $this->id = '';

        return $componentDto;
    }
}
