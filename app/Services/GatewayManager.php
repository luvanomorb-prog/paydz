<?php

namespace App\Services;

use App\Services\Gateways\MockGateway;

class GatewayManager
{

    public function get()
    {
        return new MockGateway();
    }

}
