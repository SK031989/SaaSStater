<?php

namespace Modules\RolePermission\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\RolePermission\Services\RolePermissionService;

class RolePermissionController extends Controller
{
    public function __construct(protected RolePermissionService $rolePermissionService) {}

    public function index()
    {
        $roles = $this->rolePermissionService->getAll();
        return view('RolePermission::index', compact('roles'));
    }

    public function create()
    {
        return view('RolePermission::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_name'   => 'required|string|max:255',
            'guard_name'  => 'required|string|max:100',
            'description' => 'nullable|string',
            'is_system'   => 'nullable|boolean',
        ]);

        $this->rolePermissionService->create($validated);

        return redirect()->route('rolepermissions.index')->with('success', 'Role permission created successfully.');
    }

    public function show($id)
    {
        $role = $this->rolePermissionService->findById($id);
        return view('RolePermission::show', compact('role'));
    }

    public function edit($id)
    {
        $role = $this->rolePermissionService->findById($id);
        return view('RolePermission::edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $role = $this->rolePermissionService->findById($id);

        $validated = $request->validate([
            'role_name'   => 'required|string|max:255',
            'guard_name'  => 'required|string|max:100',
            'description' => 'nullable|string',
            'is_system'   => 'nullable|boolean',
        ]);

        $this->rolePermissionService->update($role, $validated);

        return redirect()->route('rolepermissions.index')->with('success', 'Role permission updated successfully.');
    }

    public function destroy($id)
    {
        $role = $this->rolePermissionService->findById($id);
        $this->rolePermissionService->delete($role);

        return redirect()->route('rolepermissions.index')->with('success', 'Role permission deleted successfully.');
    }
}
