<?php

namespace App\Services\Gateways;

use App\Models\Payment;


interface PaymentGatewayInterface
{


    public function charge(
        Payment $payment
    ): array;



    public function verify(
        string $gatewayReference
    ): array;



    public function refund(
        Payment $payment,
        ?float $amount=null
    ): array;



    public function getName(): string;


}
