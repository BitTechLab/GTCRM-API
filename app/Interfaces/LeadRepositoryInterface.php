<?php

namespace App\Interfaces;

use App\Http\DataTransferObjects\LeadDto;
use App\Models\Lead;

interface LeadRepositoryInterface extends BaseRepositoryInterface {
    public function create(LeadDto $data): Lead;
    public function update(int $id, LeadDto $data): Lead;
}
