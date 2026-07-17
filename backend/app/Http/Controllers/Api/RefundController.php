<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\RefundService;
use App\Models\Payment;
use App\DTOs\RefundDTO;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class RefundController extends Controller
{
    public function __construct(private RefundService $refundService) {}

    public function store(Request $request, Payment $payment): JsonResponse
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'reason' => 'required|string',
        ]);

        if ($payment->status !== 'completed') {
            return response()->json(['error' => 'Payment not completed'], 400);
        }

        $dto = new RefundDTO(
            payment_id: $payment->id,
            amount: $validated['amount'],
            currency: $payment->currency,
            reason: $validated['reason'],
        );

        $refund = $this->refundService->processRefund($payment, $dto);

        return response()->json([
            'success' => true,
            'data' => $refund,
        ], 201);
    }
}
