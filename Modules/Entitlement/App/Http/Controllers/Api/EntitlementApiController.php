<?php

namespace Modules\Entitlement\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Entitlement\Services\EntitlementService;

class EntitlementApiController extends Controller
{
    public function __construct(protected EntitlementService $entitlementService) {}

    public function index()
    {
        return response()->json($this->entitlementService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id'     => 'required|integer',
            'feature_key' => 'required|string|max:100',
            'limit_value' => 'required|integer|min:0',
            'unit'        => 'required|string|max:50',
        ]);

        $entitlement = $this->entitlementService->create($validated);
        return response()->json(['message' => 'Entitlement created successfully', 'data' => $entitlement], 201);
    }

    public function show($id)
    {
        return response()->json($this->entitlementService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $entitlement = $this->entitlementService->findById($id);
        $validated = $request->validate([
            'plan_id'     => 'required|integer',
            'feature_key' => 'required|string|max:100',
            'limit_value' => 'required|integer|min:0',
            'unit'        => 'required|string|max:50',
        ]);

        $entitlement = $this->entitlementService->update($entitlement, $validated);
        return response()->json(['message' => 'Entitlement updated successfully', 'data' => $entitlement]);
    }

    public function destroy($id)
    {
        $entitlement = $this->entitlementService->findById($id);
        $this->entitlementService->delete($entitlement);
        return response()->json(['message' => 'Entitlement deleted successfully']);
    }
}
