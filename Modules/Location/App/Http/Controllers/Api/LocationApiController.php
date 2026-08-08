<?php

namespace Modules\Location\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Location\App\Models\Location;
use Modules\Location\App\Http\Requests\LocationRequest;
use Modules\Location\Services\LocationService;

class LocationApiController extends Controller
{
    public function __construct(protected LocationService $locationService) {}

    public function index(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'status', 'is_primary', 'tenant_id']);
        $locations = $this->locationService->getPaginatedLocations($filters, $request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data'    => $locations,
        ]);
    }

    public function store(LocationRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['is_primary'] = $request->boolean('is_primary');
        $location = $this->locationService->createLocation($data);

        return response()->json([
            'success' => true,
            'message' => 'Location created successfully.',
            'data'    => $location,
        ], 21);
    }

    public function show(Location $location): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data'    => $location->load('tenant'),
        ]);
    }

    public function update(LocationRequest $request, Location $location): JsonResponse
    {
        $data = $request->validated();
        $data['is_primary'] = $request->boolean('is_primary');
        $updated = $this->locationService->updateLocation($location, $data);

        return response()->json([
            'success' => true,
            'message' => 'Location updated successfully.',
            'data'    => $updated,
        ]);
    }

    public function destroy(Location $location): JsonResponse
    {
        $this->locationService->deleteLocation($location);

        return response()->json([
            'success' => true,
            'message' => 'Location deleted successfully.',
        ]);
    }
}
