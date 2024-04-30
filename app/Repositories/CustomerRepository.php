<?php

namespace App\Repositories;

use App\Http\DataTransferObjects\CustomerDto;
use App\Interfaces\CustomerRepositoryInterface;
use App\Interfaces\SearchRepositoryInterface;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class CustomerRepository implements CustomerRepositoryInterface, SearchRepositoryInterface
{
    public function __construct(private Customer $model)
    {
    }

    public function getByFilter(
        array $filters = []
    ): LengthAwarePaginator {
        return $this->model->filterable($filters)->loadable()->sortable()->paginate()->withQueryString();
    }

    public function getById(int $id)
    {
        return $this->model->loadable()->withTrashed()->findOrFail($id);
    }

    public function delete($id)
    {
        return tap($this->model->findOrFail($id))->delete();
    }

    public function create(CustomerDto $data): Customer
    {
        return $this->model->create([
            'name' => $data->name,
            'email' => $data->email,
            'status' => $data->status,
        ]);
    }

    public function update(int $id, CustomerDto $data): Customer
    {
        return tap($this->model->find($id))->update([
            'name' => $data->name,
            'email' => $data->email,
            'status' => $data->status,
        ]);
    }

    public function total(array $filter = []): int
    {
        return $this->model->filterable($filter)->count();
    }

    public function isFromLead()
    {
        return $this->model->where('is_fulfilled', true);
    }

    public function search(string $term): Collection
    {
        return Customer::query()
            ->where(fn ($query) => (
                $query->where('body', 'LIKE', "%{$term}%")
                ->orWhere('title', 'LIKE', "%{$term}%")
            ))
            ->get();
    }
}
