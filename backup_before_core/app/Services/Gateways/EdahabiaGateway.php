<?php

namespace App\Services\Gateways;

use App\Models\Payment;


class EdahabiaGateway implements PaymentGatewayInterface
{


    public function __construct(
        protected SatimGateway $satim
    ){}




    public function charge(
        Payment $payment
    ): array
    {

        return $this->satim->charge(
            $payment
        );

    }




    public function verify(
        string $gatewayReference
    ): array
    {

        return $this->satim->verify(
            $gatewayReference
        );

    }





    public function refund(
        Payment $payment,
        ?float $amount=null
    ): array
    {

        return $this->satim->refund(
            $payment,
            $amount
        );

    }





    public function getName(): string
    {
        return 'edahabia';
    }


}
