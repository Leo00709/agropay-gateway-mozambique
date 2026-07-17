<?php

namespace App\DTOs;

class RefundDTO
{
    public function __construct(
        public string $payment_id,
        public float $amount,
        public string $currency,
        public string $reason,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            payment_id: $data['payment_id'] ?? '',
            amount: (float) ($data['amount'] ?? 0),
            currency: $data['currency'] ?? 'MZN',
            reason: $data['reason'] ?? '',
        );
    }

    public function toArray(): array
    {
        return [
            'payment_id' => $this->payment_id,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'reason' => $this->reason,
        ];
    }
}
