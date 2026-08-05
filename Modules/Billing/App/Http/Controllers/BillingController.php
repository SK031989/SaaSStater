<?php

namespace Modules\Billing\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Billing\Services\BillingService;
use Modules\Tenant\App\Models\Tenant;

class BillingController extends Controller
{
    public function __construct(protected BillingService $billingService) {}

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
