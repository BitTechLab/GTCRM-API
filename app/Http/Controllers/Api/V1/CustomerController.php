<?php

namespace App\Http\Controllers\Api\V1;

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
    public function index(Request $request)
    {
        $orderBy = $request->get('order_by', config('repository.defaults.order_by'));
        $orderDirection = $request->get('order_direction', config('repository.defaults.order_direction'));

        return new CustomerCollection($this->customerRepository->getByFilter([], $orderBy, $orderDirection));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerRequest $request)
    {
        return new CustomerResource($this->customerRepository->create(CustomerDto::fromRequest($request)));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id)
    {
        return new CustomerResource($this->customerRepository->getById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        return new CustomerResource($this->customerRepository->update($customer->id, CustomerDto::fromRequest($request)));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $this->customerRepository->delete($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
