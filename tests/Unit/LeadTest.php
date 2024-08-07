<?php

use App\Models\Customer;
use App\Models\Lead;
use App\Repositories\LeadRepository;
use Illuminate\Foundation\Testing\DatabaseTruncation;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(DatabaseTruncation::class);

beforeEach(function () {
    Customer::factory()->count(10)->create();

    $this->repository = new LeadRepository(new Lead());
});

describe('Lead - get by filter', function () {

    beforeEach(function () {
        $this->dataset = Lead::factory()->count(10)->create();
    });

    it('Should have 10 rows', function () {
        $this->assertDatabaseCount('leads', 10);
    });

    it('Should get all rows without any filter', function() {
        $leads = $this->repository->getByFilter();

        expect($leads->count())->toBe(10);
    });

    it('Should get relevent data with filter', function() {
        $selectedLead = $this->dataset[0];

        $leads = $this->repository->getByFilter(['name' => $selectedLead->name]);
        expect($leads->count())->toBeGreaterThanOrEqual(1);

        $leads = $this->repository->getByFilter(['email' => $selectedLead->email]);
        expect($leads->count())->toBeGreaterThanOrEqual(1);

        $leads = $this->repository->getByFilter(['status' => $selectedLead->status]);
        expect($leads->count())->toBeGreaterThanOrEqual(1);
    });

});

describe('Lead - get by id', function () {

    beforeEach(function () {
        $this->lead = Lead::factory()->create();
    });


    it('Should get single lead', function () {
        $selectedLead = $this->repository->getById($this->lead->id);

        expect($selectedLead)->toBeInstanceOf(Lead::class);

        expect($this->lead->id)->toEqual($selectedLead->id);
    });
});