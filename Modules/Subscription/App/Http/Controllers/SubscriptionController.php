<?php

namespace Modules\Subscription\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Subscription\Services\SubscriptionService;

class SubscriptionController extends Controller
{
    public function __construct(protected SubscriptionService $subscriptionService) {}

    public function index()
    {
        $plans = $this->subscriptionService->getAll();
        return view('Subscription::index', compact('plans'));
    }

    public function create()
    {
        return view('Subscription::create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly'  => 'required|numeric|min:0',
            'max_users'     => 'required|integer|min:1',
            'is_popular'    => 'nullable|boolean',
            'status'        => 'required|string',
            'description'   => 'nullable|string',
        ]);

        $this->subscriptionService->create($validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription plan created successfully.');
    }

    public function show($id)
    {
        $plan = $this->subscriptionService->findById($id);
        return view('Subscription::show', compact('plan'));
    }

    public function edit($id)
    {
        $plan = $this->subscriptionService->findById($id);
        return view('Subscription::edit', compact('plan'));
    }

    public function update(Request $request, $id)
    {
        $plan = $this->subscriptionService->findById($id);

        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'price_monthly' => 'required|numeric|min:0',
            'price_yearly'  => 'required|numeric|min:0',
            'max_users'     => 'required|integer|min:1',
            'is_popular'    => 'nullable|boolean',
            'status'        => 'required|string',
            'description'   => 'nullable|string',
        ]);

        $this->subscriptionService->update($plan, $validated);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription plan updated successfully.');
    }

    public function destroy($id)
    {
        $plan = $this->subscriptionService->findById($id);
        $this->subscriptionService->delete($plan);

        return redirect()->route('subscriptions.index')->with('success', 'Subscription plan deleted successfully.');
    }
}
