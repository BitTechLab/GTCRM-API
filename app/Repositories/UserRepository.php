<?php

namespace App\Repositories;

use App\Http\DataTransferObjects\LoginDto;
use App\Http\DataTransferObjects\UserDto;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;

class UserRepository implements UserRepositoryInterface
{
    public function __construct(private User $model)
    {
    }

    public function getByFilter(
        array $filters = []
    ): LengthAwarePaginator {
        return $this->model->sortable()->paginate()->withQueryString();
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
        return $this->model->filterable($filter)->count();
    }

    public function authinticate(LoginDto $data): bool
    {
        return Auth::attempt([
            'email' => $data->email,
            'password' => $data->password,
        ]);
    }
}
