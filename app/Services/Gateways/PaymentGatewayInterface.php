<?php

namespace App\Services\Gateways;

interface PaymentGatewayInterface
{
    public function charge($payment);

    public function refund($payment);
}
