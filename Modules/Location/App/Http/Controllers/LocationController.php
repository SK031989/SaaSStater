<?php

namespace Modules\Location\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Location\App\Models\Location;
use Modules\Location\App\Http\Requests\LocationRequest;
use Modules\Location\Services\LocationService;
use Modules\Tenant\App\Models\Tenant;

class LocationController extends Controller
{
    public function __construct(protected LocationService $locationService) {}

    /**
     * Display a listing of locations.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'is_primary', 'tenant_id']);
        $locations = $this->locationService->getPaginatedLocations($filters);
        $tenants = auth()->user()->is_admin ? Tenant::select('id', 'name')->get() : collect();

        $stats = [
            'total'    => Location::count(),
            'active'   => Location::where('status', 'active')->count(),
            'primary'  => Location::where('is_primary', true)->count(),
            'inactive' => Location::where('status', 'inactive')->count(),
        ];

        return view('locations::index', compact('locations', 'tenants', 'stats', 'filters'));
    }

    /**
     * Show form for creating a new location.
     */
    public function create(): View
    {
        $tenants = auth()->user()->is_admin ? Tenant::select('id', 'name')->get() : collect();
        $location = new Location();

        return view('locations::create', compact('location', 'tenants'));
    }

    /**
     * Store a newly created location.
     */
    public function store(LocationRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $data['is_primary'] = $request->has('is_primary');
        $location = $this->locationService->createLocation($data);

        return redirect()->route('locations.index')
            ->with('success', "Location '{$location->name}' created successfully.");
    }

    /**
     * Display location details.
     */
    public function show(Location $location): View
    {
        return view('locations::show', compact('location'));
    }

    /**
     * Show form for editing location.
     */
    public function edit(Location $location): View
    {
        $tenants = auth()->user()->is_admin ? Tenant::select('id', 'name')->get() : collect();

        return view('locations::edit', compact('location', 'tenants'));
    }

    /**
     * Update an existing location.
     */
    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $data = $request->validated();
        $data['is_primary'] = $request->has('is_primary');
        $this->locationService->updateLocation($location, $data);

        return redirect()->route('locations.index')
            ->with('success', "Location '{$location->name}' updated successfully.");
    }

    /**
     * Remove location.
     */
    public function destroy(Location $location): RedirectResponse
    {
        $name = $location->name;
        $this->locationService->deleteLocation($location);

        return redirect()->route('locations.index')
            ->with('success', "Location '{$name}' deleted successfully.");
    }
}
