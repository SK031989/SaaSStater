<?php

namespace Modules\RolePermission\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\RolePermission\Services\RolePermissionService;

class RolePermissionApiController extends Controller
{
    public function __construct(protected RolePermissionService $rolePermissionService) {}

    public function index()
    {
        return response()->json($this->rolePermissionService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name'  => 'required|string|max:255',
            'guard_name' => 'required|string|max:100',
        ]);

        $role = $this->rolePermissionService->create($validated);
        return response()->json(['message' => 'Role created successfully', 'data' => $role], 201);
    }

    public function show($id)
    {
        return response()->json($this->rolePermissionService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $role = $this->rolePermissionService->findById($id);
        $validated = $request->validate([
            'role_name'  => 'required|string|max:255',
            'guard_name' => 'required|string|max:100',
        ]);

        $role = $this->rolePermissionService->update($role, $validated);
        return response()->json(['message' => 'Role updated successfully', 'data' => $role]);
    }

    public function destroy($id)
    {
        $role = $this->rolePermissionService->findById($id);
        $this->rolePermissionService->delete($role);
        return response()->json(['message' => 'Role deleted successfully']);
    }
}
