<?php

namespace App\Filters\QueryLoad;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;

class Lead extends BaseQueryLoad
{
    public function handle(Builder $queryBuilder, Closure $next)
    {
        return $this->process($queryBuilder, $next, 'lead');
    }
}
