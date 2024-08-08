<?php

namespace App\Filters\Query;

use App\Http\DataTransferObjects\QueryFilterDto;
use Closure;

class ByCustomer extends BaseQueryFilter
{
    public function handle(QueryFilterDto $queryFilterDto, Closure $next): QueryFilterDto
    {
        return $this->process($queryFilterDto, $next, 'customer_id', true);
    }
}
