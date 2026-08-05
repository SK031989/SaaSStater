<?php

namespace Modules\Billing\Services;

use Modules\Billing\App\Models\Invoice;

class BillingService
{
    public function getAll()
    {
        return Invoice::with('tenant')->latest()->paginate(10);
    }

    public function findById(int $id): Invoice
    {
        return Invoice::with('tenant')->findOrFail($id);
    }

    public function create(array $data): Invoice
    {
        return Invoice::create([
            'tenant_id'      => $data['tenant_id'],
            'invoice_number' => 'INV-' . strtoupper(uniqid()),
            'amount'         => $data['amount'],
            'currency'       => $data['currency'] ?? 'USD',
            'status'         => $data['status'] ?? 'pending',
            'due_date'       => $data['due_date'] ?? now()->addDays(14),
            'paid_at'        => isset($data['status']) && $data['status'] === 'paid' ? now() : null,
        ]);
    }

    public function update(Invoice $invoice, array $data): Invoice
    {
        $invoice->update([
            'tenant_id' => $data['tenant_id'],
            'amount'    => $data['amount'],
            'currency'  => $data['currency'] ?? $invoice->currency,
            'status'    => $data['status'] ?? $invoice->status,
            'due_date'  => $data['due_date'] ?? $invoice->due_date,
            'paid_at'   => isset($data['status']) && $data['status'] === 'paid' ? ($invoice->paid_at ?? now()) : null,
        ]);

        return $invoice;
    }

    public function delete(Invoice $invoice): bool
    {
        return $invoice->delete();
    }
}
