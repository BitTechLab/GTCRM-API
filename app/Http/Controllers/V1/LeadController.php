<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\LeadDto;
use App\Http\Requests\StoreLeadRequest;
use App\Http\Requests\UpdateLeadRequest;
use App\Http\Resources\BaseCollection;
use App\Http\Resources\LeadResource;
use App\Interfaces\LeadRepositoryInterface;
use App\Models\Lead;
use Illuminate\Http\Request;

class LeadController extends Controller {
    public function __construct(private LeadRepositoryInterface $leadRepository) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): BaseCollection {
        return new BaseCollection($this->leadRepository->getByFilter());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLeadRequest $request): LeadResource {
        return new LeadResource($this->leadRepository->create(LeadDto::fromRequest($request)));
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): LeadResource {
        return new LeadResource($this->leadRepository->getById($id));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLeadRequest $request, Lead $lead): LeadResource {
        return new LeadResource($this->leadRepository->update($lead?->id, LeadDto::fromRequest($request)));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): LeadResource {
        $result = $this->leadRepository->delete($id);

        return new LeadResource($result);
    }
}
