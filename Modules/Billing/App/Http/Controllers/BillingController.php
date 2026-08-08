<?php

namespace Modules\Billing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Billing\Services\BillingService;
use Modules\Tenant\App\Models\Tenant;
use Modules\Subscription\App\Models\SubscriptionPlan;
use Modules\Payment\App\Models\PaymentGateway;
use Modules\Payment\App\Models\PaymentTransaction;
use Illuminate\Support\Str;

class BillingController extends Controller
{
    public function __construct(protected BillingService $billingService) {}

    /**
     * Show Checkout Page with Billing & Payment integration.
     */
    public function checkout(Request $request)
    {
        $plans = SubscriptionPlan::all();
        $selectedPlanId = $request->input('plan_id', 2);
        $selectedPlan = $plans->where('id', $selectedPlanId)->first() ?? $plans->first();
        $gateways = PaymentGateway::active()->get();
        $addons = \Modules\Addons\App\Models\Addon::active()->get();

        $settingsPath = config_path('settings.json');
        $activeTheme = config('marketing.default_theme', 'obsidian');
        if (file_exists($settingsPath)) {
            $settings = json_decode(file_get_contents($settingsPath), true);
            $activeTheme = $settings['active_theme'] ?? $activeTheme;
        }

        $viewName = "themes.{$activeTheme}.pages.checkout";
        if (!view()->exists($viewName)) {
            $viewName = 'Billing::checkout';
        }

        return view($viewName, compact('plans', 'selectedPlan', 'gateways', 'addons'));
    }

    /**
     * Process Checkout Payment and Upgrade Subscription.
     */
    public function processCheckout(Request $request)
    {
        $request->validate([
            'plan_id'      => 'required|exists:subscription_plans,id',
            'gateway_id'   => 'required|exists:payment_gateways,id',
            'billing_name' => 'required|string|max:255',
            'billing_email'=> 'required|email|max:255',
            'company_name' => 'required|string|max:255',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->input('plan_id'));
        $gateway = PaymentGateway::findOrFail($request->input('gateway_id'));
        $interval = $request->input('billing_interval', 'monthly');

        $baseAmount = $interval === 'yearly' ? ($plan->price * 10) : $plan->price;
        $couponCode = strtoupper(trim($request->input('coupon_code', '')));
        $discount = 0;

        if ($couponCode === 'SAVE20' || $couponCode === 'WELCOME20') {
            $discount = $baseAmount * 0.20;
        } elseif ($couponCode === 'HALFOFF' || $couponCode === 'SAAS50') {
            $discount = $baseAmount * 0.50;
        }

        $finalAmount = max(0, $baseAmount - $discount);
        $tenantId = auth()->user()?->tenant_id ?? 1;

        // 1. Create Billing Invoice Record
        $invoice = $this->billingService->create([
            'tenant_id'      => $tenantId,
            'invoice_number' => 'INV-' . strtoupper(Str::random(8)),
            'amount'         => $finalAmount,
            'currency'       => 'USD',
            'status'         => 'paid',
            'due_date'       => now()->addYear(),
        ]);

        // 2. Create Payment Transaction Audit Record
        PaymentTransaction::create([
            'tenant_id'      => $tenantId,
            'user_id'        => auth()->id(),
            'gateway_id'     => $gateway->id,
            'transaction_id' => 'TXN-' . strtoupper(Str::random(10)),
            'amount'         => $finalAmount,
            'currency'       => 'USD',
            'status'         => 'completed',
            'payment_method' => $gateway->code,
            'metadata'       => [
                'plan_name'     => $plan->name,
                'interval'      => $interval,
                'coupon_applied'=> $couponCode ?: 'NONE',
            ],
        ]);

        // 3. Upgrade Tenant Subscription Plan
        if (auth()->check() && auth()->user()->tenant) {
            auth()->user()->tenant->update(['plan_id' => $plan->id]);
        }

        $redirectUrl = (auth()->check() && auth()->user()->is_admin)
            ? route('billings.index')
            : route('dashboard');

        return redirect($redirectUrl)
            ->with('success', "🎉 Checkout completed successfully! Invoice #{$invoice->invoice_number} paid via {$gateway->name}. Subscription upgraded to {$plan->name}.");
    }

    public function index()
    {
        $invoices = $this->billingService->getAll();
        return view('Billing::index', compact('invoices'));
    }

    public function create()
    {
        $tenants = Tenant::all();
        return view('Billing::create', compact('tenants'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenant_id' => 'required|integer',
            'amount'    => 'required|numeric|min:0',
            'currency'  => 'required|string|max:10',
            'status'    => 'required|string',
            'due_date'  => 'nullable|date',
        ]);

        $this->billingService->create($validated);

        return redirect()->route('billings.index')->with('success', 'Invoice created successfully.');
    }

    public function show($id)
    {
        $invoice = $this->billingService->findById($id);
        return view('Billing::show', compact('invoice'));
    }

    public function edit($id)
    {
        $invoice = $this->billingService->findById($id);
        $tenants = Tenant::all();
        return view('Billing::edit', compact('invoice', 'tenants'));
    }

    public function update(Request $request, $id)
    {
        $invoice = $this->billingService->findById($id);

        $validated = $request->validate([
            'tenant_id' => 'required|integer',
            'amount'    => 'required|numeric|min:0',
            'currency'  => 'required|string|max:10',
            'status'    => 'required|string',
            'due_date'  => 'nullable|date',
        ]);

        $this->billingService->update($invoice, $validated);

        return redirect()->route('billings.index')->with('success', 'Invoice updated successfully.');
    }

    public function destroy($id)
    {
        $invoice = $this->billingService->findById($id);
        $this->billingService->delete($invoice);

        return redirect()->route('billings.index')->with('success', 'Invoice deleted successfully.');
    }
}
