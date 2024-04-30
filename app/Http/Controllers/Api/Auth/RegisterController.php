<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\UserDto;
use App\Http\Requests\StoreUserRequest;
use App\Http\Resources\RegisterResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function __construct(private UserRepositoryInterface $userRepository)
    {
    }
    /**
     * Handle the incoming request.
     */
    public function __invoke(StoreUserRequest $request): RegisterResource|JsonResponse
    {
        $user = $this->userRepository->create(UserDto::fromRequest($request));

        if ($user) {
            return (new RegisterResource([
                'message' => 'Registration successful',
            ]))->response()
                ->setStatusCode(201);
        } else {
            return response()->json(['error' => 'Error occurred while creating the user']);
        }
    }
}
