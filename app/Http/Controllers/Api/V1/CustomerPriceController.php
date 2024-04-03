<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCustomerPriceRequest;
use App\Http\Requests\UpdateCustomerPriceRequest;
use App\Models\CustomerPrice;

class CustomerPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCustomerPriceRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(CustomerPrice $customerPrice)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CustomerPrice $customerPrice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCustomerPriceRequest $request, CustomerPrice $customerPrice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomerPrice $customerPrice)
    {
        //
    }
}
