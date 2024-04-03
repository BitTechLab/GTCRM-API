<?php

namespace App\Traits;

use App\Http\DataTransferObjects\QueryFilterDto;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;

trait QueryBuilderFilter
{
    public function applyFilter(array $providedFilter = []): Builder
    {
        if (!$this->queryBuilder) {
            $this->queryBuilder = $this->model->newQuery();
        }

        if (!isset($this->filter) || !is_array($this->filter)) {
            return $this->queryBuilder;
        }

        // Apply the filters
        $queryFilterDto = Pipeline::send(new QueryFilterDto($this->queryBuilder, $providedFilter))
            ->through($this->filter)
            ->thenReturn();

        return $queryFilterDto->builder;
    }
}
