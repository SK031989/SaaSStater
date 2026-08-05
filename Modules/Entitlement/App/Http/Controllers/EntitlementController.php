<?php

namespace Modules\Entitlement\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Entitlement\Services\EntitlementService;
use Modules\Subscription\App\Models\SubscriptionPlan;

class EntitlementController extends Controller
{
    public function __construct(protected EntitlementService $entitlementService) {}

    public function index()
    {
        $entitlements = $this->entitlementService->getAll();
        return view('Entitlement::index', compact('entitlements'));
    }

    public function create()
    {
        $plans = SubscriptionPlan::all();
        return view('Entitlement::create', compact('plans'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'plan_id'      => 'required|integer',
            'feature_key'  => 'required|string|max:100',
            'feature_name' => 'nullable|string|max:255',
            'limit_value'  => 'required|integer|min:0',
            'unit'         => 'required|string|max:50',
            'is_unlimited' => 'nullable|boolean',
        ]);

        $this->entitlementService->create($validated);

        return redirect()->route('entitlements.index')->with('success', 'Entitlement rule created successfully.');
    }

    public function show($id)
    {
        $entitlement = $this->entitlementService->findById($id);
        return view('Entitlement::show', compact('entitlement'));
    }

    public function edit($id)
    {
        $entitlement = $this->entitlementService->findById($id);
        $plans = SubscriptionPlan::all();
        return view('Entitlement::edit', compact('entitlement', 'plans'));
    }

    public function update(Request $request, $id)
    {
        $entitlement = $this->entitlementService->findById($id);

        $validated = $request->validate([
            'plan_id'      => 'required|integer',
            'feature_key'  => 'required|string|max:100',
            'feature_name' => 'nullable|string|max:255',
            'limit_value'  => 'required|integer|min:0',
            'unit'         => 'required|string|max:50',
            'is_unlimited' => 'nullable|boolean',
        ]);

        $this->entitlementService->update($entitlement, $validated);

        return redirect()->route('entitlements.index')->with('success', 'Entitlement rule updated successfully.');
    }

    public function destroy($id)
    {
        $entitlement = $this->entitlementService->findById($id);
        $this->entitlementService->delete($entitlement);

        return redirect()->route('entitlements.index')->with('success', 'Entitlement rule deleted successfully.');
    }
}
