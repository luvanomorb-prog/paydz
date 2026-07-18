<?php

namespace App\Services\Payment\Pipeline;

use App\Services\GatewayManager;
use RuntimeException;

class ChargeGateway
{
    public function __construct(
        protected GatewayManager $gateways
    ) {
    }

    public function handle(array $payload): array
    {
        $payment = $payload['payment'];

        $gateway = $this->gateways->driver($payment->method);

        $response = $gateway->charge($payment);

        if (! ($response['success'] ?? false)) {

            throw new RuntimeException(
                $response['error_message'] ?? 'Payment gateway error.'
            );

        }

        $payload['gateway'] = $gateway;

        $payload['gateway_response'] = $response;

        return $payload;
    }
}
