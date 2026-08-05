<?php

namespace Modules\ApiKey\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\ApiKey\Services\ApiKeyService;

class ApiKeyApiController extends Controller
{
    public function __construct(protected ApiKeyService $apiKeyService) {}

    public function index()
    {
        return response()->json($this->apiKeyService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|integer',
            'name'      => 'required|string|max:255',
        ]);

        $key = $this->apiKeyService->create($validated);
        return response()->json(['message' => 'API Key generated', 'data' => $key], 201);
    }

    public function show($id)
    {
        return response()->json($this->apiKeyService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $key = $this->apiKeyService->findById($id);
        $validated = $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|string',
        ]);

        $key = $this->apiKeyService->update($key, $validated);
        return response()->json(['message' => 'API Key updated', 'data' => $key]);
    }

    public function destroy($id)
    {
        $key = $this->apiKeyService->findById($id);
        $this->apiKeyService->delete($key);
        return response()->json(['message' => 'API Key revoked']);
    }
}
