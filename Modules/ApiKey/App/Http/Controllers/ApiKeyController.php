<?php

namespace Modules\ApiKey\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ApiKey\Services\ApiKeyService;
use Modules\Tenant\App\Models\Tenant;

class ApiKeyController extends Controller
{
    public function __construct(protected ApiKeyService $apiKeyService) {}

    public function index()
    {
        $apiKeys = $this->apiKeyService->getAll();
        return view('ApiKey::index', compact('apiKeys'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        return view('ApiKey::create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|integer',
            'name'      => 'required|string|max:255',
            'status'    => 'required|string',
        ]);

        $this->apiKeyService->create($validated);

        return redirect()->route('apikeys.index')->with('success', 'API Key generated successfully.');
    }

    public function show($id)
    {
        $apiKey = $this->apiKeyService->findById($id);
        return view('ApiKey::show', compact('apiKey'));
    }

    public function edit($id)
    {
        $apiKey = $this->apiKeyService->findById($id);
        $tenants = Tenant::all();
        return view('ApiKey::edit', compact('apiKey', 'tenants'));
    }

    public function update(Request $request, $id)
    {
        $apiKey = $this->apiKeyService->findById($id);

        $validated = $request->validate([
            'tenant_id' => 'required|integer',
            'name'      => 'required|string|max:255',
            'status'    => 'required|string',
        ]);

        $this->apiKeyService->update($apiKey, $validated);

        return redirect()->route('apikeys.index')->with('success', 'API Key updated successfully.');
    }

    public function destroy($id)
    {
        $apiKey = $this->apiKeyService->findById($id);
        $this->apiKeyService->delete($apiKey);

        return redirect()->route('apikeys.index')->with('success', 'API Key revoked and deleted successfully.');
    }
}
