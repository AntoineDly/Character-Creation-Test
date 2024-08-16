<?php

declare(strict_types=1);

namespace App\Users\Builders;

use App\Helpers\UuidHelper;
use App\Shared\Builders\BuilderInterface;
use App\Shared\Exceptions\NotAValidUuidException;
use App\Shared\Exceptions\StringIsEmptyException;
use App\Users\Dtos\UserDto;

final class UserDtoBuilder implements BuilderInterface
{
    public string $id = '';

    public string $name = '';

    public string $email = '';

    public string $token = '';

    public function setId(string $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function setToken(string $token): self
    {
        $this->token = $token;

        return $this;
    }

    public function build(): UserDto
    {
        if (! UuidHelper::isValidUuid($this->id)) {
            throw new NotAValidUuidException('id field is not a valid uuid, '.$this->id.' given.', code: 400);
        }

        if ($this->name === '') {
            throw new StringIsEmptyException('name field is empty', code: 400);
        }

        if ($this->email === '') {
            throw new StringIsEmptyException('email field is empty', code: 400);
        }

        if ($this->token === '') {
            throw new StringIsEmptyException('token field is empty', code: 400);
        }

        $userDto = new UserDto(
            id: $this->id,
            name: $this->name,
            email: $this->email,
            token: $this->token
        );

        $this->id = $this->name = $this->email = $this->token = '';

        return $userDto;
    }
}
