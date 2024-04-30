<?php

namespace App\Filters\Query;

use App\Http\DataTransferObjects\QueryFilterDto;
use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class WithTrashed
{
    const FIELD_KEY = 'with_trashed';

    public function handle(QueryFilterDto $queryFilterDto, Closure $next): QueryFilterDto
    {
        // Check if with_trashed=true passed for the field name
        if (Arr::get($queryFilterDto->filter, self::FIELD_KEY)) {
            $queryFilterDto->builder->withTrashed();
        }

        return $next($queryFilterDto);
    }
}
