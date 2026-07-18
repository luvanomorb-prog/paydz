<?php

namespace App\Services\Gateways;

use App\Models\Payment;
use Illuminate\Support\Str;

class BaridiMobGateway implements PaymentGatewayInterface
{


    public function charge(Payment $payment): array
    {

        return [

            'success' => true,

            'status' => 'paid',

            'reference' =>
                'BMD_' . strtoupper(Str::random(18)),

            'provider' => 'BARIDIMOB',

        ];

    }




    public function verify(string $gatewayReference): array
    {

        return [

            'success' => true,

            'status' => 'paid',

            'reference' => $gatewayReference,

        ];

    }





    public function refund(
        Payment $payment,
        ?float $amount = null
    ): array {

        return [

            'success' => true,

            'status' => 'refunded',

            'amount' =>
                $amount ?? $payment->amount,

        ];

    }




    public function getName(): string
    {

        return 'baridimob';

    }

}
