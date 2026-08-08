<?php

namespace Modules\Payment\Services;

use Modules\Payment\App\Models\PaymentGateway;
use Modules\Payment\App\Models\PaymentTransaction;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PaymentService
{
    /**
     * Get all active payment gateways.
     */
    public function getActiveGateways()
    {
        return PaymentGateway::active()->get();
    }

    /**
     * Get paginated transactions.
     */
    public function getPaginatedTransactions(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = PaymentTransaction::with(['tenant', 'user', 'gateway'])->latest();

        // Tenant Scoping
        if (auth()->check() && !auth()->user()->is_admin) {
            $query->forTenant(auth()->user()->tenant_id);
        } elseif (!empty($filters['tenant_id'])) {
            $query->forTenant($filters['tenant_id']);
        }

        // Search Filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('transaction_id', 'like', "%{$search}%")
                  ->orWhere('payment_method', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($uq) use ($search) {
                      $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Status Filter
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Toggle Gateway Active Status
     */
    public function toggleGatewayStatus(PaymentGateway $gateway): PaymentGateway
    {
        $gateway->is_active = !$gateway->is_active;
        $gateway->save();

        return $gateway;
    }

    /**
     * Update Gateway Config Credentials
     */
    public function updateGateway(PaymentGateway $gateway, array $data): PaymentGateway
    {
        if (!empty($data['is_default'])) {
            PaymentGateway::where('id', '!=', $gateway->id)->update(['is_default' => false]);
        }

        $gateway->update($data);
        return $gateway->fresh();
    }

    /**
     * Record a new transaction (Simulation or Real Webhook)
     */
    public function recordTransaction(array $data): PaymentTransaction
    {
        if (empty($data['transaction_id'])) {
            $data['transaction_id'] = 'TXN-' . strtoupper(Str::random(10));
        }

        return PaymentTransaction::create($data);
    }
}
