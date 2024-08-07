<?php

use App\Models\Customer;
use App\Repositories\CustomerRepository;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(DatabaseTruncation::class);

beforeEach(function () {
    $this->repository = new CustomerRepository(new Customer());
});

describe('Customer - get by filter', function () {

    beforeEach(function () {
        $this->dataset = Customer::factory()->count(10)->create();
    });

    it('Should have 10 rows', function () {
        $this->assertDatabaseCount('customers', 10);
    });

    it('Should get all rows without any filter', function() {
        $customers = $this->repository->getByFilter();

        expect($customers->count())->toBe(10);
    });

    it('Should get relevent data with filter', function() {
        $selectedCustomer = $this->dataset[0];

        $customers = $this->repository->getByFilter(['name' => $selectedCustomer->name]);
        expect($customers->count())->toBeGreaterThanOrEqual(1);

        $customers = $this->repository->getByFilter(['email' => $selectedCustomer->email]);
        expect($customers->count())->toBeGreaterThanOrEqual(1);

        $customers = $this->repository->getByFilter(['status' => $selectedCustomer->status]);
        expect($customers->count())->toBeGreaterThanOrEqual(1);
    });

});

describe('Customer - get by id', function () {

    beforeEach(function () {
        $this->customer = Customer::factory()->create();
    });


    it('Should get single customer', function () {
        $selectedCustomer = $this->repository->getById($this->customer->id);

        expect($selectedCustomer)->toBeInstanceOf(Customer::class);

        expect($this->customer->id)->toEqual($selectedCustomer->id);
    });
});
