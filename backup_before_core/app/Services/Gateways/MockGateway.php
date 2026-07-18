<?php

namespace App\Services\Gateways;

use App\Models\Payment;
use Illuminate\Support\Str;

class MockGateway implements PaymentGatewayInterface
{
    public function charge(Payment $payment): array
    {
        return [

            'success' => true,

            'status' => 'paid',

            'gateway_reference' =>
                'MOCK_' . strtoupper(Str::random(20)),

            'redirect_url' => null,

            'raw_response' => [

                'code' => '00',

                'message' => 'Mock payment approved',

            ],

            'error_message' => null,

        ];
    }

    public function verify(string $gatewayReference): array
    {
        return [

            'success' => true,

            'status' => 'paid',

            'gateway_reference' => $gatewayReference,

            'raw_response' => [

                'verified' => true,

            ],

            'error_message' => null,

        ];
    }

    public function refund(Payment $payment, ?float $amount = null): array
    {
        return [

            'success' => true,

            'status' => 'refunded',

            'gateway_reference' =>
                $payment->provider_reference,

            'raw_response' => [

                'refunded' => true,

            ],

            'error_message' => null,

        ];
    }

    public function getName(): string
    {
        return 'mock';
    }
}
