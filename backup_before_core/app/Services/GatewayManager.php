<?php

namespace App\Services;

use InvalidArgumentException;
use App\Services\Gateways\CibGateway;
use App\Services\Gateways\MockGateway;
use App\Services\Gateways\SatimGateway;
use App\Services\Gateways\BaridiMobGateway;
use App\Services\Gateways\EdahabiaGateway;
use App\Services\Gateways\PaymentGatewayInterface;

class GatewayManager
{
    /**
     * Return gateway instance.
     */
    public function driver(string $method): PaymentGatewayInterface
    {
        return match (strtolower($method)) {

            /*
            |--------------------------------------------------------------------------
            | CIB
            |--------------------------------------------------------------------------
            */

            'cib' => new CibGateway(
                new SatimGateway()
            ),

            /*
            |--------------------------------------------------------------------------
            | Edahabia
            |--------------------------------------------------------------------------
            */

            'edahabia' => new EdahabiaGateway(
                new SatimGateway()
            ),

            /*
            |--------------------------------------------------------------------------
            | BaridiMob
            |--------------------------------------------------------------------------
            */

            'baridimob' => new BaridiMobGateway(),

            /*
            |--------------------------------------------------------------------------
            | Default
            |--------------------------------------------------------------------------
            */

            'mock' => new MockGateway(),

            default => throw new InvalidArgumentException(
                "Unsupported payment gateway [$method]"
            ),
        };
    }
}
