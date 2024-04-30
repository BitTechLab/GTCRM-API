<?php

namespace App\Traits\Database;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Pipeline;

trait Loadable
{
    public function loadable(): Builder|model
    {
        if (!$this->loadable || !is_array($this->loadable)) {
            return $this;
        }

        // Check and include the additional for with()
        return Pipeline::send($this::query())
            ->through($this->loadable)
            ->thenReturn();
    }

    public function getLoadable(): array
    {
        return isset($this->loadable) ? $this->loadable : [];
    }
}
