<?php

namespace App\DTOs;

class PaymentDTO
{
    public function __construct(
        public string $reference,
        public float $amount,
        public string $currency,
        public string $method,
        public ?string $customer_email = null,
        public ?string $customer_phone = null,
        public ?string $description = null,
        public ?array $metadata = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            reference: $data['reference'] ?? '',
            amount: (float) ($data['amount'] ?? 0),
            currency: $data['currency'] ?? 'MZN',
            method: $data['method'] ?? '',
            customer_email: $data['customer_email'] ?? null,
            customer_phone: $data['customer_phone'] ?? null,
            description: $data['description'] ?? null,
            metadata: $data['metadata'] ?? null,
        );
    }

    public function toArray(): array
    {
        return [
            'reference' => $this->reference,
            'amount' => $this->amount,
            'currency' => $this->currency,
            'method' => $this->method,
            'customer_email' => $this->customer_email,
            'customer_phone' => $this->customer_phone,
            'description' => $this->description,
            'metadata' => $this->metadata,
        ];
    }
}
