<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Requests\Api\Auth\{
    AuthApiRequest
};

use App\Repositories\{
    UserRepository
};

use Illuminate\Support\Facades\{
    Auth,
    Hash
};

use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Validation\ValidationException;

class AuthApiController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function auth(AuthApiRequest $request)
    {
        $user = $this->userRepository->findByEmail($request->email);
     
        if (! $user || ! Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages(['email' => ['The provided credentials are incorrect.']]);
        }
     
        // Autênciação de um token por usuário somente
        $user->tokens()->delete();
        $token = $user->createToken($request->device_name)->plainTextToken;
        return response()->json(['token' => $token]);
    }

    public function logout()
    {
        Auth::user()->tokens()->delete();
        return response()->json(['message' => 'Tokens Revoked'], Response::HTTP_NO_CONTENT);
    }

    public function me()
    {
        return response()->json(['user' => Auth::user()]);
    }
}
