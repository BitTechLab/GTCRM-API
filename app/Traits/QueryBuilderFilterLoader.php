<?php

namespace App\Traits;

use App\Traits\QueryBuilderFilter;
use App\Traits\QueryBuilderLoader;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;

trait QueryBuilderFilterLoader
{
    use QueryBuilderFilter, QueryBuilderLoader;

    protected ?Builder $queryBuilder = null;

    /**
     * @return Builder
     */
    public function applyFilterAndLoader(array $providedFilter = []): Builder
    {
        if (!$this->model) {
            throw new ModelNotFoundException("Model is not set in RepositoryQueryFilter");
        }

        if (!$this->queryBuilder) {
            $this->queryBuilder = $this->model->newQuery();
        }

        $this->applyfilter($providedFilter);
        $this->applyLoader();

        return $this->queryBuilder;
    }
}
