<?php

namespace App\Services\Payment\Pipeline;

use App\Services\TransactionService;

class FinalizePayment
{
    public function __construct(
        protected TransactionService $transactions
    ) {
    }

    public function handle(array $payload): array
    {
        $payment = $payload['payment'];

        $transaction = $payload['transaction'];

        $response = $payload['gateway_response'];

        $transaction->update([

            'gateway' => $payload['gateway']->getName(),

            'gateway_reference' => $response['gateway_reference'] ?? null,

            'provider_reference' => $response['gateway_reference'] ?? null,

            'raw_response' => $response,

        ]);

        if (($response['status'] ?? null) === 'paid') {

            $this->transactions->complete($transaction);

        } elseif (($response['status'] ?? null) === 'requires_action') {

            $payment->update([

                'status' => 'processing',

                'provider_reference' => $response['gateway_reference'] ?? null,

            ]);

            $transaction->update([

                'status' => 'processing',

            ]);

        } else {

            $this->transactions->fail(

                $transaction,

                $response['error_message'] ?? 'Payment failed.'

            );

        }

        return $payload;
    }
}
