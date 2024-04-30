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
        readonly public string $email,
        readonly public string $status,
    ) {
    }

    public static function fromRequest(StoreCustomerRequest|UpdateCustomerRequest $request): static
    {
        return new static(
            name: $request->validated('name'),
            email: $request->validated('email'),
            status: $request->validated('status'),
        );
    }

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'],
            email: $data['email'],
            status: $data['status'],
        );
    }
}
