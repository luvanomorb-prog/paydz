<?php

namespace App\Services\Transaction;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Str;

class TransactionService
{
    public function create(Payment $payment): Transaction
    {
        return Transaction::create([
            'payment_id' => $payment->id,
            'transaction_id' => 'TRX_' . strtoupper(Str::random(20)),
            'amount' => $payment->amount,
            'currency' => $payment->currency,
            'status' => 'pending',
        ]);
    }

    public function markProcessing(Transaction $transaction): void
    {
        $transaction->update([
            'status' => 'processing',
        ]);
    }

    public function markPaid(Transaction $transaction): void
    {
        $transaction->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        $transaction->payment->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);
    }

    public function markFailed(Transaction $transaction, string $reason): void
    {
        $transaction->update([
            'status' => 'failed',
            'failure_reason' => $reason,
        ]);

        $transaction->payment->update([
            'status' => 'failed',
        ]);
    }
}
