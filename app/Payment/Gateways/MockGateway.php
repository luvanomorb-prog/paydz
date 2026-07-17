<?php

namespace App\Payment\Gateways;

use App\Models\Payment;
use App\Payment\Contracts\GatewayInterface;

class MockGateway implements GatewayInterface
{
    public function create(Payment $payment): array
    {
        return [
            'success' => true,
            'reference' => 'MOCK_' . uniqid(),
            'status' => 'pending',
            'checkout_url' => route('checkout.show', [
                'session' => $payment->payment_id,
            ]),
        ];
    }

    public function verify(Payment $payment): array
    {
        return [
            'success' => true,
            'status' => 'paid',
            'reference' => $payment->provider_reference,
        ];
    }

    public function refund(Payment $payment, float $amount): array
    {
        return [
            'success' => true,
            'amount' => $amount,
        ];
    }

    public function cancel(Payment $payment): array
    {
        return [
            'success' => true,
        ];
    }

    public function name(): string
    {
        return 'mock';
    }
}
