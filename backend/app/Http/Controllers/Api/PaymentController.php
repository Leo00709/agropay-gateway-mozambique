<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use App\Models\Payment;
use App\DTOs\PaymentDTO;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class PaymentController extends Controller
{
    public function __construct(private PaymentService $paymentService) {}

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reference' => 'required|string|unique:payments',
            'amount' => 'required|numeric|min:1',
            'currency' => 'required|string|in:MZN,USD',
            'method' => 'required|string|in:mpesa,emola,visa,mastercard',
            'customer_email' => 'email|nullable',
            'customer_phone' => 'string|nullable',
            'description' => 'string|nullable',
            'metadata' => 'array|nullable',
        ]);

        $merchant = auth()->user()->merchants()->first();
        if (!$merchant) {
            return response()->json(['error' => 'Merchant not found'], 404);
        }

        $dto = PaymentDTO::fromArray($validated);
        $payment = $this->paymentService->createPayment($merchant, $dto);

        return response()->json([
            'success' => true,
            'data' => $payment,
        ], 201);
    }

    public function show(Payment $payment): JsonResponse
    {
        return response()->json([
            'success' => true,
            'data' => $this->paymentService->getPaymentStatus($payment),
        ]);
    }

    public function index(Request $request): JsonResponse
    {
        $merchant = auth()->user()->merchants()->first();
        $payments = Payment::where('merchant_id', $merchant->id)
            ->paginate(20);

        return response()->json([
            'success' => true,
            'data' => $payments->items(),
            'pagination' => [
                'total' => $payments->total(),
                'per_page' => $payments->perPage(),
                'current_page' => $payments->currentPage(),
                'last_page' => $payments->lastPage(),
            ],
        ]);
    }
}
