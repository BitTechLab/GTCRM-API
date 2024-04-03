<?php

namespace App\Filters\QueryLoad;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Addresses extends BaseQueryLoad
{
    public function handle(Builder $queryBuilder, Closure $next)
    {
        return $this->process($queryBuilder, $next, 'addresses');
    }
}
