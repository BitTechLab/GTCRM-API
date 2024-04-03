<?php

namespace App\Repositories;

use App\Http\DataTransferObjects\CustomerDto;
use App\Http\DataTransferObjects\LoginDto;
use App\Http\DataTransferObjects\RegisterDto;
use App\Http\DataTransferObjects\UserDto;
use App\Interfaces\UserRepositoryInterface;
use App\Models\Customer;
use App\Models\User;
use App\Traits\QueryBuilderFilterLoader;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    use QueryBuilderFilterLoader;

    protected array $filter = [
        // \App\Filters\Query\ByName::class,
        // \App\Filters\Query\ByEmail::class,
    ];

    protected array $load = [
        // \App\Filters\QueryLoad\Lead::class,
        // \App\Filters\QueryLoad\Addresses::class,
    ];

    public function __construct(private User $model)
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

    public function create(UserDto $data): User
    {
        return $this->model->create([
            'name' => $data->name,
            'email' => $data->email,
            'password' => bcrypt($data->password),
        ]);
    }

    public function update(int $id, UserDto $data): User
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

    public function authinticate(LoginDto $data): bool
    {
        return Auth::attempt([
            'email' => $data->email,
            'password' => $data->password,
        ]);
    }
}
