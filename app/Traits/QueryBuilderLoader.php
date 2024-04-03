<?php

namespace App\Traits;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Pipeline;

trait QueryBuilderLoader
{
    public function applyLoader(): Builder
    {
        if (!$this->queryBuilder) {
            $this->queryBuilder = $this->model->newQuery();
        }


        if (!isset($this->load) || !is_array($this->load)) {
            return $this->queryBuilder;
        }

        // Check and include the additional for with()
        return Pipeline::send($this->queryBuilder)
            ->through($this->load)
            ->thenReturn();
    }
}
