<?php

namespace Modules\Payment\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Modules\Payment\App\Models\PaymentGateway;
use Modules\Payment\App\Models\PaymentTransaction;
use Modules\Payment\Services\PaymentService;

class PaymentController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    /**
     * Display Gateway Settings & Transaction Audit Trail.
     */
    public function index(Request $request): View
    {
        $filters = $request->only(['search', 'status', 'tenant_id']);
        $gateways = PaymentGateway::all();
        $transactions = $this->paymentService->getPaginatedTransactions($filters);

        $stats = [
            'total_transactions' => PaymentTransaction::count(),
            'total_revenue'      => PaymentTransaction::completed()->sum('amount'),
            'active_gateways'    => PaymentGateway::where('is_active', true)->count(),
            'pending_count'      => PaymentTransaction::where('status', 'pending')->count(),
        ];

        return view('payments::index', compact('gateways', 'transactions', 'stats', 'filters'));
    }

    /**
     * Show edit form for payment gateway credentials.
     */
    public function edit(PaymentGateway $gateway): View
    {
        return view('payments::edit', compact('gateway'));
    }

    /**
     * Update payment gateway credentials.
     */
    public function update(Request $request, PaymentGateway $gateway): RedirectResponse
    {
        $request->validate([
            'name'         => 'required|string|max:100',
            'mode'         => 'required|in:sandbox,live',
            'credentials'  => 'nullable|array',
            'instructions' => 'nullable|string|max:1000',
        ]);

        $data = [
            'name'         => $request->input('name'),
            'mode'         => $request->input('mode'),
            'credentials'  => $request->input('credentials', []),
            'instructions' => $request->input('instructions'),
            'is_active'    => $request->has('is_active'),
            'is_default'   => $request->has('is_default'),
        ];

        $this->paymentService->updateGateway($gateway, $data);

        return redirect()->route('payments.index')
            ->with('success', "Payment Gateway '{$gateway->name}' configuration updated successfully.");
    }

    /**
     * Toggle Gateway Active Status.
     */
    public function toggle(PaymentGateway $gateway): RedirectResponse
    {
        $this->paymentService->toggleGatewayStatus($gateway);
        $statusStr = $gateway->is_active ? 'activated' : 'deactivated';

        return redirect()->route('payments.index')
            ->with('success', "Payment Gateway '{$gateway->name}' {$statusStr}.");
    }

    /**
     * Show transaction details.
     */
    public function showTransaction(PaymentTransaction $transaction): View
    {
        return view('payments::show', compact('transaction'));
    }
}
