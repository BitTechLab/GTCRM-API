<?php

namespace App\Filters\Query;

use App\Http\DataTransferObjects\QueryFilterDto;
use Closure;

class ByName extends BaseQueryFilter
{
    public function handle(QueryFilterDto $queryFilterDto, Closure $next)
    {
        return $this->process($queryFilterDto, $next, 'name', true);
    }
}
