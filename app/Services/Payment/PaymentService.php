<?php

namespace App\Services\Payment;

use App\Models\Merchant;
use App\Services\Payment\Pipeline\PaymentPipeline;
use App\Services\Payment\Pipeline\ValidatePayment;
use App\Services\Payment\Pipeline\CreatePayment;
use App\Services\Payment\Pipeline\CreateTransaction;
use App\Services\Payment\Pipeline\ChargeGateway;
use App\Services\Payment\Pipeline\FinalizePayment;

class PaymentService
{
    public function __construct(
        protected PaymentPipeline $pipeline
    ) {
    }

    public function create(Merchant $merchant, array $data): array
    {
        $payload = array_merge($data, [

            'merchant_id' => $merchant->id,

            'currency' => $data['currency'] ?? 'DZD',

        ]);

        return $this->pipeline

            ->through([

                ValidatePayment::class,

                CreatePayment::class,

                CreateTransaction::class,

                ChargeGateway::class,

                FinalizePayment::class,

            ])

            ->process($payload);
    }
}
