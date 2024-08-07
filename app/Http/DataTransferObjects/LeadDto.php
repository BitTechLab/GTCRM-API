<?php

namespace App\Http\DataTransferObjects;

use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;

class LeadDto
{

    public function __construct(
        readonly public string $name,
        readonly public string $email,
        readonly public string $source,
        readonly public string $customerId,
        readonly public string $status,
    ) {
    }

    public static function fromRequest(StoreLeadRequest|UpdateLeadRequest $request): static
    {
        return new static(
            name: $request->validated('name'),
            email: $request->validated('email'),
            source: $request->validated('source'),
            customerId: $request->validated('customer_id'),
            status: $request->validated('status'),
        );
    }

    public static function fromArray(array $data): static
    {
        return new static(
            name: $data['name'],
            email: $data['email'],
            source: $data['source'],
            customerId: $data['customer_id'],
            status: $data['status'],
        );
    }
}
