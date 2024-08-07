<?php

namespace App\Interfaces;

use App\Http\DataTransferObjects\CustomerDto;
use App\Models\Customer;

interface CustomerRepositoryInterface extends BaseRepositoryInterface
{
    public function create(CustomerDto $data): Customer;
    public function update(int $id, CustomerDto $data): Customer;
}
