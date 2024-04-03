<?php

namespace App\Http\DataTransferObjects;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class UserDto
{

    public function __construct(
        readonly public string $name,
        readonly public string $email,
        readonly public string $password
    ) {
    }

    public static function fromRequest(StoreUserRequest|UpdateUserRequest $request): static
    {
        return new static(
            name: $request->validated('name'),
            email: $request->validated('email'),
            password: $request->validated('password')
        );
    }
}
