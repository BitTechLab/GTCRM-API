<?php

namespace App\Repositories;

use App\Http\DataTransferObjects\CustomerDto;
use App\Http\DataTransferObjects\QueryFilterDto;
use App\Interfaces\CustomerRepositoryInterface;
use App\Models\Customer;
use App\Traits\QueryBuilderFilter;
use App\Traits\QueryBuilderFilterLoader;
use App\Traits\QueryBuilderLoader;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Pipeline;

class CustomerRepository implements CustomerRepositoryInterface
{
    use QueryBuilderFilterLoader;

    protected array $filter = [
        \App\Filters\Query\ByName::class,
        \App\Filters\Query\ByEmail::class,
    ];

    protected array $load = [
        \App\Filters\QueryLoad\Lead::class,
        \App\Filters\QueryLoad\Addresses::class,
    ];

    public function __construct(private Customer $model)
    {
    }

    public function getAll(
        int $offset = 0,
        int $limit = 20,
        string $orderBy = 'id',
        string $orderDirection = 'asc'
    ): Collection {
        return $this->model->offset($offset)->limit($limit)->orderBy($orderBy, $orderDirection)->get();
    }

    public function getByFilter(
        array $providedFilter = [],
        string $orderBy = 'id',
        string $orderDirection = 'asc'
    ): LengthAwarePaginator {
        return $this->applyFilterAndLoader($providedFilter)?->orderBy($orderBy, $orderDirection)->paginate()->withQueryString();
    }

    public function getById(int $id)
    {
        return $this->model->findOrFail($id);
    }

    public function delete($id)
    {
        $this->model->destroy($id);
    }

    public function create(CustomerDto $data): Customer
    {
        return $this->model->create([
            'name' => $data->name,
            'email' => $data->email,
        ]);
    }

    public function update(int $id, CustomerDto $data): Customer
    {
        return tap($this->model->find($id))->update([
            'name' => $data->name,
            'email' => $data->email,
        ]);
    }

    public function total(array $filter = []): int
    {
        return $this->applyFilterAndLoader($filter)->count();
    }

    public function isFromLead()
    {
        return $this->model->where('is_fulfilled', true);
    }
}
