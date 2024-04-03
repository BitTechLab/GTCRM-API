<?php

namespace App\Interfaces;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BaseRepositoryInterface
{
    public function getAll(
        int $offset = 0,
        int $limit = 10,
        string $orderBy = 'id',
        string $orderDirection = 'asc'
    ): Collection;
    public function getByFilter(
        array $filter = [],
        string $orderBy = 'id',
        string $orderDirection = 'asc'
    ): LengthAwarePaginator;
    public function getById(int $id);
    public function delete(int $id);
    public function total(array $fitler = []): int;
}
