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
}
