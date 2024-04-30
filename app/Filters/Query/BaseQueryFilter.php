<?php

namespace App\Filters\Query;

use App\Http\DataTransferObjects\QueryFilterDto;
use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class BaseQueryFilter
{

    public function __construct(protected Request $request)
    {
    }

    public function process(QueryFilterDto $queryFilterDto, Closure $next, string $fieldKey, bool $shouldSearch = false): QueryFilterDto
    {
        // Check if any filter passes for the field name
        if (Arr::has($queryFilterDto->filter, $fieldKey) || $this->request->has($fieldKey)) {
            $fieldValue = Arr::get($queryFilterDto->filter, $fieldKey, $this->request->{$fieldKey});

            // Match value with the field if value is passed for the filter
            // Ignore if the passed value is blank
            if ($fieldValue) {
                $queryFilterDto->builder->where($fieldKey, '=', Arr::get($queryFilterDto->filter, $fieldKey, $this->request->{$fieldKey}));
            }
        }

        // Check if any filter passed as {field name}_search
        if ($shouldSearch && $this->request->has($fieldKey . '_search')) {
            $searchTerm = Arr::get($queryFilterDto->filter, $fieldKey . '_search', $this->request->{$fieldKey . '_search'});

            // Check if the search term filter/parameter has any value or not
            // Ignore if search term/string is blank
            if ($searchTerm) {
                $queryFilterDto->builder->where($fieldKey, '~*', $searchTerm);
            }
        }

        return $next($queryFilterDto);
    }
}
