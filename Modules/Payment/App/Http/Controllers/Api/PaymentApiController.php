<?php

namespace Modules\Payment\App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Modules\Payment\App\Models\PaymentGateway;
use Modules\Payment\App\Models\PaymentTransaction;
use Modules\Payment\Services\PaymentService;

class PaymentApiController extends Controller
{
    public function __construct(protected PaymentService $paymentService) {}

    public function gateways(): JsonResponse
    {
        $gateways = PaymentGateway::active()->get(['id', 'name', 'code', 'mode', 'is_default', 'instructions']);

        return response()->json([
            'success' => true,
            'data'    => $gateways,
        ]);
    }

    public function transactions(Request $request): JsonResponse
    {
        $filters = $request->only(['search', 'status', 'tenant_id']);
        $transactions = $this->paymentService->getPaginatedTransactions($filters, $request->input('per_page', 15));

        return response()->json([
            'success' => true,
            'data'    => $transactions,
        ]);
    }

    public function storeTransaction(Request $request): JsonResponse
    {
        $request->validate([
            'gateway_id'     => 'required|exists:payment_gateways,id',
            'amount'         => 'required|numeric|min:0.01',
            'currency'       => 'nullable|string|max:10',
            'payment_method' => 'nullable|string|max:50',
        ]);

        $data = [
            'tenant_id'      => auth()->user()?->tenant_id,
            'user_id'        => auth()->id(),
            'gateway_id'     => $request->input('gateway_id'),
            'amount'         => $request->input('amount'),
            'currency'       => $request->input('currency', 'USD'),
            'payment_method' => $request->input('payment_method', 'card'),
            'status'         => 'completed',
        ];

        $transaction = $this->paymentService->recordTransaction($data);

        return response()->json([
            'success' => true,
            'message' => 'Payment transaction created successfully.',
            'data'    => $transaction,
        ], 201);
    }
}
