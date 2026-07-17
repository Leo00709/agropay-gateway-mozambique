<?php

namespace App\Services;

use App\DTOs\PaymentDTO;
use App\Models\Payment;
use App\Models\Merchant;
use Illuminate\Support\Str;

class PaymentService
{
    public function createPayment(Merchant $merchant, PaymentDTO $dto): Payment
    {
        $payment = Payment::create([
            'merchant_id' => $merchant->id,
            'reference' => $dto->reference,
            'amount' => $dto->amount,
            'currency' => $dto->currency,
            'method' => $dto->method,
            'status' => 'pending',
            'customer_email' => $dto->customer_email,
            'customer_phone' => $dto->customer_phone,
            'description' => $dto->description,
            'metadata' => $dto->metadata,
            'checkout_url' => config('app.url') . '/checkout/' . Str::random(32),
        ]);

        return $payment;
    }

    public function getPaymentStatus(Payment $payment): array
    {
        return [
            'id' => $payment->id,
            'status' => $payment->status,
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'reference' => $payment->reference,
            'created_at' => $payment->created_at,
            'completed_at' => $payment->completed_at,
        ];
    }

    public function updatePaymentStatus(Payment $payment, string $status): void
    {
        $payment->update([
            'status' => $status,
            'completed_at' => $status === 'completed' ? now() : null,
        ]);
    }
}
