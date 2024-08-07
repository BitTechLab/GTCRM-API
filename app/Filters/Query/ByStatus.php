<?php

namespace App\Filters\Query;

use App\Http\DataTransferObjects\QueryFilterDto;
use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

class ByStatus extends BaseQueryFilter
{
    public function handle(QueryFilterDto $queryFilterDto, Closure $next): QueryFilterDto
    {
        return $this->process($queryFilterDto, $next, 'status', true);
    }
}
