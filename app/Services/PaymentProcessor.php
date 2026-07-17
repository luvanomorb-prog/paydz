<?php

namespace App\Services;

class PaymentProcessor
{

    public function __construct(
        protected GatewayManager $gateway
    ){}


    public function process($payment)
    {

        return $this->gateway
                    ->get()
                    ->charge($payment);

    }

}
