<?php

namespace Modules\Tenant\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tenant\Services\TenantService;

class TenantApiController extends Controller
{
    public function __construct(protected TenantService $tenantService) {}

    public function index()
    {
        return response()->json($this->tenantService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'subdomain' => 'required|string|max:100|unique:tenants,subdomain',
            'status'    => 'required|string',
        ]);

        $tenant = $this->tenantService->create($validated);
        return response()->json(['message' => 'Tenant created successfully', 'data' => $tenant], 201);
    }

    public function show($id)
    {
        return response()->json($this->tenantService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $tenant = $this->tenantService->findById($id);
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|max:255',
            'subdomain' => 'required|string|max:100|unique:tenants,subdomain,' . $tenant->id,
            'status'    => 'required|string',
        ]);

        $tenant = $this->tenantService->update($tenant, $validated);
        return response()->json(['message' => 'Tenant updated successfully', 'data' => $tenant]);
    }

    public function destroy($id)
    {
        $tenant = $this->tenantService->findById($id);
        $this->tenantService->delete($tenant);
        return response()->json(['message' => 'Tenant deleted successfully']);
    }
}
