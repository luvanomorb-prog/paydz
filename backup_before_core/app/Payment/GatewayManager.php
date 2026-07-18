<?php

namespace App\Payment;

use App\Payment\Contracts\GatewayInterface;
use App\Payment\Gateways\MockGateway;
use InvalidArgumentException;

class GatewayManager
{
    /**
     * Resolve a payment gateway by name.
     */
    public function driver(string $driver = 'mock'): GatewayInterface
    {
        return match (strtolower($driver)) {

            'mock' => new MockGateway(),

            /*
             * سيتم إضافتها لاحقًا
             */
            // 'satim' => new SATIMGateway(),
            // 'cib' => new CIBGateway(),
            // 'edahabia' => new EdahabiaGateway(),
            // 'baridimob' => new BaridiMobGateway(),

            default => throw new InvalidArgumentException(
                "Unsupported payment gateway [{$driver}]"
            ),
        };
    }
}
