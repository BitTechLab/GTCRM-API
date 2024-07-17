<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\DataTransferObjects\LoginDto;
use App\Http\Requests\LoginRequest;
use App\Http\Resources\LoginResource;
use App\Interfaces\UserRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response as FacadesResponse;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function __construct(protected UserRepositoryInterface $userRepository)
    {
    }

    public function index(Request $request): LoginResource
    {
        $user = $request->user();

        return new LoginResource([
            'message' => 'Auth successful',
            'user' => $user,
        ]);
    }

    public function login(LoginRequest $request): LoginResource|JsonResponse
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

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();
        Session::flush();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }
}
