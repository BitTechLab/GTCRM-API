<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\LoginDto;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function login(LoginRequest $request)
    {
        $loginAttempt = $this->userRepository->authinticate(LoginDto::fromRequest($request));

        if (!$loginAttempt) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        $user = $request->user();
        $tokenResult = $user->createToken('accessToken');

        return new LoginResource([
            'message' => 'Login successful',
            'accessToken' => $tokenResult->plainTextToken,
            'tokenType' => 'Bearer',
            'user' => $user,
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
