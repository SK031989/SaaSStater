<?php

namespace Modules\Billing\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Billing\Services\BillingService;

class BillingApiController extends Controller
{
    public function __construct(protected BillingService $billingService) {}

    public function index()
    {
        return response()->json($this->billingService->getAll());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|integer',
            'amount'    => 'required|numeric|min:0',
            'currency'  => 'required|string|max:10',
            'status'    => 'required|string',
        ]);

        $invoice = $this->billingService->create($validated);
        return response()->json(['message' => 'Invoice created successfully', 'data' => $invoice], 201);
    }

    public function show($id)
    {
        return response()->json($this->billingService->findById($id));
    }

    public function update(Request $request, $id)
    {
        $invoice = $this->billingService->findById($id);
        $validated = $request->validate([
            'tenant_id' => 'required|integer',
            'amount'    => 'required|numeric|min:0',
            'status'    => 'required|string',
        ]);

        $invoice = $this->billingService->update($invoice, $validated);
        return response()->json(['message' => 'Invoice updated successfully', 'data' => $invoice]);
    }

    public function destroy($id)
    {
        $invoice = $this->billingService->findById($id);
        $this->billingService->delete($invoice);
        return response()->json(['message' => 'Invoice deleted successfully']);
    }

    /**
     * Process API Checkout & Subscription Upgrade.
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'plan_id'          => 'required|exists:subscription_plans,id',
            'gateway_id'       => 'required|exists:payment_gateways,id',
            'billing_name'     => 'nullable|string|max:255',
            'billing_email'    => 'nullable|email|max:255',
            'company_name'     => 'nullable|string|max:255',
            'billing_interval' => 'nullable|string|in:monthly,yearly',
            'coupon_code'      => 'nullable|string|max:50',
            'addons'           => 'nullable|array',
        ]);

        $user = auth()->user();
        $plan = \Modules\Subscription\App\Models\SubscriptionPlan::findOrFail($validated['plan_id']);
        $gateway = \Modules\Payment\App\Models\PaymentGateway::findOrFail($validated['gateway_id']);
        $interval = $validated['billing_interval'] ?? 'monthly';

        // Base price + Addons calculation
        $baseAmount = ($interval === 'yearly') ? $plan->price_yearly : $plan->price_monthly;
        $addonsTotal = 0;
        if (!empty($validated['addons']) && is_array($validated['addons'])) {
            $addonsTotal = \Modules\Addons\App\Models\Addon::whereIn('id', $validated['addons'])->sum('price');
            if ($interval === 'yearly') {
                $addonsTotal = $addonsTotal * 10;
            }
        }

        // Coupon discount calculation
        $couponCode = strtoupper(trim($validated['coupon_code'] ?? ''));
        $discount = 0;
        if (in_array($couponCode, ['SAVE20', 'WELCOME20'])) {
            $discount = ($baseAmount + $addonsTotal) * 0.20;
        } elseif (in_array($couponCode, ['HALFOFF', 'SAAS50'])) {
            $discount = ($baseAmount + $addonsTotal) * 0.50;
        }

        $finalAmount = max(0, ($baseAmount + $addonsTotal) - $discount);

        // Update Tenant Plan
        if ($user && $user->tenant) {
            $user->tenant->update(['plan_id' => $plan->id]);
        }

        // Generate Invoice
        $invoice = \Modules\Billing\App\Models\Invoice::create([
            'tenant_id'      => $user?->tenant_id ?? 1,
            'invoice_number' => 'INV-' . strtoupper(\Illuminate\Support\Str::random(8)),
            'amount'         => $finalAmount,
            'currency'       => 'USD',
            'status'         => 'paid',
            'due_date'       => now()->addYear(),
        ]);

        // Payment Transaction Log
        $transaction = \Modules\Payment\App\Models\PaymentTransaction::create([
            'tenant_id'      => $user?->tenant_id ?? 1,
            'user_id'        => $user?->id ?? 1,
            'gateway_id'     => $gateway->id,
            'transaction_id' => 'TXN-' . strtoupper(\Illuminate\Support\Str::random(10)),
            'amount'         => $finalAmount,
            'currency'       => 'USD',
            'status'         => 'completed',
            'payment_method' => $gateway->code,
            'metadata'       => [
                'plan_name'      => $plan->name,
                'interval'       => $interval,
                'coupon_applied' => $couponCode ?: 'NONE',
            ],
        ]);

        return response()->json([
            'success'     => true,
            'message'     => 'Checkout and subscription upgrade completed successfully.',
            'invoice'     => $invoice,
            'transaction' => $transaction,
        ], 200);
    }
}
