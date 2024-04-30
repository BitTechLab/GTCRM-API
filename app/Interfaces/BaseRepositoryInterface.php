<?php

namespace App\Interfaces;

use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function getByFilter(
        array $filters =  []
    ): LengthAwarePaginator;
    public function getById(int $id);
    public function delete(int $id);
    public function total(array $fitler = []): int;
}
