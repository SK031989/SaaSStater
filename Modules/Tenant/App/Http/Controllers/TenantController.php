<?php

namespace Modules\Tenant\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Tenant\Services\TenantService;

class TenantController extends Controller
{
    public function __construct(protected TenantService $tenantService) {}

    public function index()
    {
        $tenants = $this->tenantService->getAll();
        return view('Tenant::index', compact('tenants'));
    }

    public function create()
    {
        return view('Tenant::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'subdomain'     => 'required|string|max:100|unique:tenants,subdomain',
            'company_name'  => 'nullable|string|max:255',
            'status'        => 'required|string',
            'custom_domain' => 'nullable|string|max:255',
        ]);

        $this->tenantService->create($validated);

        return redirect()->route('tenants.index')->with('success', 'Tenant created successfully.');
    }

    public function show($id)
    {
        $tenant = $this->tenantService->findById($id);
        return view('Tenant::show', compact('tenant'));
    }

    public function edit($id)
    {
        $tenant = $this->tenantService->findById($id);
        return view('Tenant::edit', compact('tenant'));
    }

    public function update(Request $request, $id)
    {
        $tenant = $this->tenantService->findById($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'subdomain'     => 'required|string|max:100|unique:tenants,subdomain,' . $tenant->id,
            'company_name'  => 'nullable|string|max:255',
            'status'        => 'required|string',
            'custom_domain' => 'nullable|string|max:255',
        ]);

        $this->tenantService->update($tenant, $validated);

        return redirect()->route('tenants.index')->with('success', 'Tenant updated successfully.');
    }

    public function destroy($id)
    {
        $tenant = $this->tenantService->findById($id);
        $this->tenantService->delete($tenant);

        return redirect()->route('tenants.index')->with('success', 'Tenant deleted successfully.');
    }
}
