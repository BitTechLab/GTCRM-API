<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSaleProductRequest;
use App\Http\Requests\UpdateSaleProductRequest;
use App\Models\SaleProduct;

class SaleProductController extends Controller
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
    public function store(StoreSaleProductRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(SaleProduct $saleProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SaleProduct $saleProduct)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSaleProductRequest $request, SaleProduct $saleProduct)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SaleProduct $saleProduct)
    {
        //
    }
}
