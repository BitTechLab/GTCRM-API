<?php

namespace App\Traits\Database;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait Sortable
{
    public function sortable(): Builder|Model
    {
        $sort = request()->get('sort');

        if (!$sort) {
            return $this;
        }

        if (!property_exists($this, 'sortable')) {
            return $this;
        }

        if (!in_array($sort, $this->sortable)) {
            return $this;
        }

        $direction = strtolower(request()->get('direction', 'asc'));

        if (!in_array($direction, ['asc', 'desc'])) {
            return $this;
        }

        return $this->orderBy($sort, $direction);
    }

    public function getSortable(): array
    {
        return isset($this->sortable) ? $this->sortable : [];
    }
}
