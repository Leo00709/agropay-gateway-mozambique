<?php

namespace App\Services;

use App\DTOs\RefundDTO;
use App\Models\Payment;
use App\Models\Refund;

class RefundService
{
    public function processRefund(Payment $payment, RefundDTO $dto): Refund
    {
        $refund = Refund::create([
            'payment_id' => $payment->id,
            'amount' => $dto->amount,
            'currency' => $dto->currency,
            'reason' => $dto->reason,
            'status' => 'processing',
        ]);

        return $refund;
    }

    public function completeRefund(Refund $refund, ?string $gateway_refund_id = null): void
    {
        $refund->update([
            'status' => 'completed',
            'gateway_refund_id' => $gateway_refund_id,
            'processed_at' => now(),
        ]);
    }

    public function failRefund(Refund $refund, string $error): void
    {
        $refund->update([
            'status' => 'failed',
        ]);
    }
}
