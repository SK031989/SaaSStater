<?php

namespace Modules\Addons\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Addons\Services\AddonService;

class AddonApiController extends Controller
{
    public function __construct(protected AddonService $addonService) {}

    public function index()
    {
        return response()->json($this->addonService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'price_monthly' => 'required|numeric|min:0',
            'status'        => 'required|string',
        ]);

        $addon = $this->addonService->create($validated);
        return response()->json(['message' => 'Addon created successfully', 'data' => $addon], 201);
    }

    public function show($id)
    {
        return response()->json($this->addonService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $addon = $this->addonService->findById($id);
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'price_monthly' => 'required|numeric|min:0',
            'status'        => 'required|string',
        ]);

        $addon = $this->addonService->update($addon, $validated);
        return response()->json(['message' => 'Addon updated successfully', 'data' => $addon]);
    }

    public function destroy($id)
    {
        $addon = $this->addonService->findById($id);
        $this->addonService->delete($addon);
        return response()->json(['message' => 'Addon deleted successfully']);
    }
}
