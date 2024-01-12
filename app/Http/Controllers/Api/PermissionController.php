<?php

namespace App\Http\Controllers\Api;

use App\DTO\Permissions\{
    CreatePermissionDTO,
    UpdatePermissionDTO
};

use App\Http\Controllers\Controller;

use App\Http\Requests\Api\Permissions\{
    StorePermissionRequest,
    UpdatePermissionRequest
};

use App\Http\Resources\{
    PermissionResource
};

use App\Repositories\{
    PermissionRepository
};

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PermissionController extends Controller
{
    public function __construct(private PermissionRepository $permissionRepository)
    {
        $this->permissionRepository = $permissionRepository;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $permission = $this->permissionRepository->getPaginate(
            totalPerPage: $request->total_per_page ?? 15,
            page: $request->page ?? 1,
            filter: $request->filter ?? ''
        );

        return PermissionResource::collection($permission);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePermissionRequest $request)
    {
        $permission = $this->permissionRepository->createNew(new CreatePermissionDTO(... $request->validated()));
        return new PermissionResource($permission);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!$permission = $this->permissionRepository->findById($id)) {
            return response()->json(['message' => 'Permission not found'], Response::HTTP_NOT_FOUND);
        }
        
        return new PermissionResource($permission);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePermissionRequest $request, string $id)
    {
        $response = $this->permissionRepository->update(new UpdatePermissionDTO(...[$id, ...$request->validated()]));
        if (!$response) {
            return response()->json(['message' => 'permission not found'], Response::HTTP_NOT_FOUND);
        }
        return response()->json(['message' => 'permission updated with success']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (!$this->permissionRepository->delete($id)) {
            return response()->json(['message' => 'Permission not found'], Response::HTTP_NOT_FOUND);
        }

        return response()->json(['message' => 'Permission deleted with sucess'], Response::HTTP_OK);
    }
}
