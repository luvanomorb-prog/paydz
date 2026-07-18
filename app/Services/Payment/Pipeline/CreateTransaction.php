<?php

namespace App\Services\Payment\Pipeline;

use App\Services\TransactionService;

class CreateTransaction
{
    public function __construct(
        protected TransactionService $transactions
    ) {
    }

    public function handle(array $payload): array
    {
        $transaction = $this->transactions->create(
            $payload['payment']
        );

        $payload['transaction'] = $transaction;

        return $payload;
    }
}
