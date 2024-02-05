<?php

namespace App\Http\Controllers\Api;

use App\Repositories\{
    UserRepository
};

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpFoundation\Response;

class PermissionUserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function syncPermissionOfUser(Request $request, string $id)
    {
        $response = $this->userRepository->syncPermission($id, $request->permissions);
        
        if (!$response) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Permission sync with success'], Response::HTTP_OK);
    }
}
