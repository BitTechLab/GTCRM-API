<?php

namespace App\Providers;

use App\Http\DataTransferObjects\QueryFilterDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;
use Illuminate\Support\ServiceProvider;

class QueryBuilderServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Builder::macro('sortable', function () {
            $sort = request()->get('sort');

            if (!$sort) {
                return $this;
            }

            if (!property_exists($this, 'model')) {
                return $this;
            }

            if (
                !property_exists($this->model, 'sortable')
                || !method_exists($this->model, 'getSortable')
            ) {
                return $this;
            }

            if (!in_array($sort, $this->model->getSortable())) {
                return $this;
            }

            $direction = strtolower(request()->get('direction', 'asc'));

            if (!in_array($direction, ['asc', 'desc'])) {
                return $this;
            }

            $this->orderBy($sort, $direction);

            return $this;
        });

        Builder::macro('filterable', function (array $filter = []) {
            if (
                !property_exists($this->model, 'filterable')
                || !method_exists($this->model, 'getFilterable')
            ) {
                return $this;
            }

            // Apply the filters
            $queryFilterDto = Pipeline::send(new QueryFilterDto($this, $filter))
                ->through($this->model->getFilterable())
                ->thenReturn();

            return $queryFilterDto->builder;
        });
        
        Builder::macro('loadable', function () {
            if (
                !property_exists($this->model, 'loadable')
                || !method_exists($this->model, 'getLoadable')
            ) {
                return $this;
            }
    
            // Check and include the additional for with()
            return Pipeline::send($this)
                ->through($this->model->getLoadable())
                ->thenReturn();
        });
    }
}
