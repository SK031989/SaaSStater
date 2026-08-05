<?php

namespace Modules\Subscription\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Subscription\Services\SubscriptionService;

class SubscriptionApiController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptionService) {}

    public function index()
    {
        return response()->json($this->subscriptionService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly'  => 'required|numeric|min:0',
            'max_users'     => 'required|integer|min:1',
            'status'        => 'required|string',
        ]);

        $plan = $this->subscriptionService->create($validated);
        return response()->json(['message' => 'Plan created successfully', 'data' => $plan], 201);
    }

    public function show($id)
    {
        return response()->json($this->subscriptionService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $plan = $this->subscriptionService->findById($id);
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly'  => 'required|numeric|min:0',
            'max_users'     => 'required|integer|min:1',
            'status'        => 'required|string',
        ]);

        $plan = $this->subscriptionService->update($plan, $validated);
        return response()->json(['message' => 'Plan updated successfully', 'data' => $plan]);
    }

    public function destroy($id)
    {
        $plan = $this->subscriptionService->findById($id);
        $this->subscriptionService->delete($plan);
        return response()->json(['message' => 'Plan deleted successfully']);
    }
}
