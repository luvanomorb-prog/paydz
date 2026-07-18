<?php

namespace App\Services\Payment\Pipeline;

use InvalidArgumentException;

class ValidatePayment
{
    public function handle(array $payload): array
    {
        foreach ([
            'merchant_id',
            'amount',
            'currency',
            'method'
        ] as $field) {

            if (! array_key_exists($field, $payload)) {

                throw new InvalidArgumentException(
                    "Missing required field [$field]"
                );

            }

        }

        if ($payload['amount'] <= 0) {

            throw new InvalidArgumentException(
                'Invalid payment amount.'
            );

        }

        return $payload;
    }
}
