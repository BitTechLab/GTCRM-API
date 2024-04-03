<?php

namespace App\Http\DataTransferObjects;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;

class LoginDto
{

    public function __construct(
        readonly public string $email,
        readonly public string $password
    ) {
    }

    public static function fromRequest(LoginRequest $request): static
    {
        return new static(
            email: $request->validated('email'),
            password: $request->validated('password')
        );
    }
}
