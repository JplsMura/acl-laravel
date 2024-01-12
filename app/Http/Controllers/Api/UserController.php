<?php

namespace App\Http\Controllers\Api;

use App\DTO\Users\{
    CreateUserDTO,
    UpdateUserDTO
};

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\Users\{
    StoreUserRequest,
    UpdateUserRequest
};

use App\Http\Resources\{
    UserResource
};

use App\Repositories\{
    UserRepository
};

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $this->userRepository->getPaginate(
            totalPerPage: $request->total_per_page ?? 15,
            page: $request->page ?? 1,
            filter: $request->filter ?? ''
        );

        return UserResource::collection($user);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request)
    {
        $user = $this->userRepository->createNew(new CreateUserDTO(... $request->validated()));
        return new UserResource($user);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$user = $this->userRepository->findById($id)) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }
        
        return new UserResource($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, string $id)
    {
        $response = $this->userRepository->update(new UpdateUserDTO(...[$id, ...$request->validated()]));

        if (!$response) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'User update with sucess'], Response::HTTP_OK);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->userRepository->delete($id)) {
            return response()->json(['message' => 'User not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'User deleted with sucess'], Response::HTTP_OK);
    }
}
