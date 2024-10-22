<?php

declare(strict_types=1);

namespace App\Components\Builders;

use App\Components\Dtos\ComponentDto;
use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\Http\NotAValidUuidException;

final class ComponentDtoBuilder implements BuilderInterface
{
    private string $id = '';

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function build(): ComponentDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.');
        }

        $componentDto = new ComponentDto(
            id: $this->id
        );

        $this->id = '';

        return $componentDto;
    }
}
