<?php

declare(strict_types=1);

namespace App\Users\Domain\Dtos\UserDto;

use App\Helpers\UuidHelper;
use App\Shared\Domain\Dtos\BuilderInterface;
use App\Shared\Infrastructure\Http\Exceptions\NotAValidUuidException;
use App\Shared\Infrastructure\Http\Exceptions\StringIsEmptyException;

final class UserDtoBuilder implements BuilderInterface
{
    public string $id = '';

    public string $email = '';

    public string $token = '';

    public function setId(string $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function setToken(string $token): static
    {
        $this->token = $token;

        return $this;
    }

    public function build(): UserDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException(data: ['value' => $this->id]);
        }

        if ($this->email === '') {
            throw new StringIsEmptyException(data: ['field' => 'email']);
        }

        if ($this->token === '') {
            throw new StringIsEmptyException(data: ['field' => 'token']);
        }

        $userDto = new UserDto(
            id: $this->id,
            email: $this->email,
            token: $this->token
        );

        $this->id = $this->email = $this->token = '';

        return $userDto;
    }
}
