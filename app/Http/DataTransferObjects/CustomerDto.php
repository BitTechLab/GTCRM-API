<?php

namespace App\Http\DataTransferObjects;

use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Interfaces\DtoInterface;
use Illuminate\Http\Request;

class CustomerDto
{

    public function __construct(
        readonly public string $name,
        readonly public string $email
    ) {
    }

    public static function fromRequest(StoreCustomerRequest|UpdateCustomerRequest $request): static
    {
        return new static(
            name: $request->validated('name'),
            email: $request->validated('email'),
        );
    }
}
