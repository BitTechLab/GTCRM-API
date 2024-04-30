<?php

namespace App\Traits\Database;

use App\Http\DataTransferObjects\QueryFilterDto;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Pipeline;

trait Filterable
{
    public function filterable(array $providedFilter = []): Builder|Model
    {
        if (!isset($this->filterable) || !is_array($this->filterable)) {
            return $this;
        }

        // Apply the filters
        $queryFilterDto = Pipeline::send(new QueryFilterDto($this::query(), $providedFilter))
            ->through($this->filterable)
            ->thenReturn();

        return $queryFilterDto->builder;
    }

    public function getFilterable(): array
    {
        return isset($this->filterable) ? $this->filterable : [];
    }
}
