<?php

namespace App\Http\DataTransferObjects;

use Illuminate\Contracts\Database\Eloquent\Builder;

class QueryFilterDto {
    public function __construct(
        public Builder $builder,
        public array $filter
    ){}
}