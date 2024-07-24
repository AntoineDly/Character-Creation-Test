<?php

declare(strict_types=1);

namespace App\User\Builders;

use App\Base\Builders\BuilderInterface;
use App\Base\Exceptions\NotAValidUuidException;
use App\Base\Exceptions\StringIsEmptyException;
use App\Helpers\UuidHelper;
use App\User\Dtos\UserDto;

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
