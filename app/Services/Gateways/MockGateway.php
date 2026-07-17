<?php

namespace App\Services\Gateways;

class MockGateway implements PaymentGatewayInterface
{

    public function charge($payment)
    {
        return [
            'status'=>'success',
            'reference'=>'MOCK_'.uniqid()
        ];
    }


    public function refund($payment)
    {
        return [
            'status'=>'refunded'
        ];
    }

}
