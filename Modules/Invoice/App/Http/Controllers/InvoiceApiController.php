<?php

namespace Modules\Invoice\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Modules\Invoice\App\Models\Invoice;
use Modules\Invoice\App\Http\Requests\StoreInvoiceRequest;
use Modules\Invoice\App\Http\Requests\UpdateInvoiceRequest;

class InvoiceApiController extends Controller
{
    /**
     * GET /api/v1/invoices
     */
    public function index(Request $request): JsonResponse
    {
        $this->authorize('viewAny', Invoice::class);

        $items = Invoice::query()
            ->forTenant(auth()->user()->tenant_id)
            ->when($request->search, fn($q) => $q->search($request->search))
            ->latest()
            ->paginate($request->per_page ?? 15);

        return response()->json($items);
    }

    /**
     * POST /api/v1/invoices
     */
    public function store(StoreInvoiceRequest $request): JsonResponse
    {
        $this->authorize('create', Invoice::class);

        $data              = $request->validated();
        $data['tenant_id'] = auth()->user()->tenant_id;

        $item = Invoice::create($data);

        return response()->json(['data' => $item, 'message' => 'Invoice created.'], 201);
    }

    /**
     * GET /api/v1/invoices/{id}
     */
    public function show(Invoice $invoice): JsonResponse
    {
        $this->authorize('view', $invoice);

        return response()->json(['data' => $invoice]);
    }

    /**
     * PUT /api/v1/invoices/{id}
     */
    public function update(UpdateInvoiceRequest $request, Invoice $invoice): JsonResponse
    {
        $this->authorize('update', $invoice);

        $invoice->update($request->validated());

        return response()->json(['data' => $invoice->fresh(), 'message' => 'Invoice updated.']);
    }

    /**
     * DELETE /api/v1/invoices/{id}
     */
    public function destroy(Invoice $invoice): JsonResponse
    {
        $this->authorize('delete', $invoice);

        $invoice->delete();

        return response()->json(['message' => 'Invoice deleted.']);
    }
}