<?php

namespace App\Filters\QueryLoad;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class BaseQueryLoad
{

    public function __construct(protected Request $request)
    {
    }

    public function process(Builder $queryBuilder, Closure $next, string $loadKey)
    {
        if ($this->request->has(config('repository.load_param'))) {
            $loadKeys = $this->request->get(config('repository.load_param'));

            if (is_array($loadKeys) && in_array($loadKey, $loadKeys)) {
                $queryBuilder->with($loadKey);
            }
        }

        return $next($queryBuilder);
    }
}
