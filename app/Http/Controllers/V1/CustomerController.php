<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\CustomerDto;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Http\Resources\CustomerCollection;
use App\Http\Resources\CustomerResource;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CustomerController extends Controller
{

    public function __construct(private CustomerRepositoryInterface $customerRepository)
    {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): CustomerCollection
    {
        // test code. remove it as soon as you see it. you can blame webhkp for this(as he forgot to remove this line)
        $this->customerRepository->create(CustomerDto::fromArray([
            'name' => 'test name - ' . rand(),
            'email' => rand() . '-test@name.com',
            'status' => 'active',
        ]));

        return new CustomerCollection($this->customerRepository->getByFilter());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request): CustomerResource
    {
        return new CustomerResource($this->customerRepository->create(CustomerDto::fromRequest($request)));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): CustomerResource
    {
        return new CustomerResource($this->customerRepository->getById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer): CustomerResource
    {
        return new CustomerResource($this->customerRepository->update($customer?->id, CustomerDto::fromRequest($request)));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): CustomerResource
    {
        $result = $this->customerRepository->delete($id);

        return new CustomerResource($result);
    }
}
