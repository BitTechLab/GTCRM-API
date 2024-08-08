<?php

use App\Http\DataTransferObjects\LeadDto;
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

describe('Lead - create', function() {
    it('Should create lead with proper default values', function() {
        $lead = $this->repository->create(LeadDto::fromArray([
            'name' => 'first lead',
            'email' => 'first_lead@gtmux.com',
        ]));

        $this->assertModelExists($lead);

        expect($lead)->toBeInstanceOf(Lead::class);
        expect($lead->id)->not()->toBeNull();
        expect($lead->name)->toBe('first lead');
        expect($lead->email)->toBe('first_lead@gtmux.com');
        expect($lead->customer_id)->toBeNull();
        expect($lead->source)->toBeNull();
        expect($lead->status)->toBe('new');
    });
});

describe('Lead - update', function() {
    it('Should update lead properly', function() {
        $createdLead = Lead::factory()->create();

        $updatedLead = $this->repository->update($createdLead->id, LeadDto::fromArray([
            'name' => 'first lead',
            'email' => 'first_lead@gtmux.com',
            'status' => 'active',
        ]));

        $this->assertModelExists($updatedLead);

        expect($updatedLead)->toBeInstanceOf(Lead::class);
        expect($updatedLead->id)->not()->toBeNull();
        expect($updatedLead->id)->toBe($createdLead->id);
        expect($updatedLead->name)->toBe('first lead');
        expect($updatedLead->email)->toBe('first_lead@gtmux.com');
        expect($updatedLead->status)->toBe('active');
    });
});

describe("Lead - delete", function() {
    it('Should delete lead with soft delete', function() {
        $createdLead = Lead::factory()->create();

        $deletedLead = $this->repository->delete($createdLead->id);

        $this->assertSoftDeleted($deletedLead);

        expect($deletedLead)->toBeInstanceOf(Lead::class);
        expect($deletedLead->id)->toBe($createdLead->id);
    });
});