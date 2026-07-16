<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\Transaction\TransactionService;

class PaymentSimulatorController extends Controller
{
    public function __construct(
        protected TransactionService $transactionService
    ) {}

    public function success(string $paymentId)
    {
        $payment = Payment::where('payment_id', $paymentId)
            ->firstOrFail();

        $transaction = $payment->transactions()->latest()->first();

        if (! $transaction) {
            abort(404, 'Transaction not found');
        }

        $this->transactionService->markPaid($transaction);

        return redirect('/pay/' . $paymentId)
            ->with('success', 'Payment completed successfully.');
    }

    public function fail(string $paymentId)
    {
        $payment = Payment::where('payment_id', $paymentId)
            ->firstOrFail();

        $transaction = $payment->transactions()->latest()->first();

        if (! $transaction) {
            abort(404, 'Transaction not found');
        }

        $this->transactionService->markFailed(
            $transaction,
            'Payment declined.'
        );

        return redirect('/pay/' . $paymentId)
            ->with('error', 'Payment failed.');
    }
}
