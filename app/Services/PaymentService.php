<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Merchant;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class PaymentService
{

    /**
     * Create Payment
     */
    public function createPayment(array $data)
    {
        return DB::transaction(function () use ($data) {


            // Check merchant
            $merchant = Merchant::findOrFail($data['merchant_id']);


            // Create Payment ID
            $paymentIntentId = 'pi_PDZ_' . strtoupper(Str::random(18));


            // Create payment
            $payment = Payment::create([

                'merchant_id' => $merchant->id,

                'payment_id' => $paymentIntentId,

                'amount' => $data['amount'],

                'currency' => $data['currency'] ?? 'DZD',

                'customer_email' => $data['customer_email'],

                'customer_name' => $data['customer_name'] ?? null,

                'description' => $data['description'] ?? null,

                'status' => 'pending',

                'provider' => null,

                'provider_reference' => null,

                'metadata' => $data['metadata'] ?? null,

            ]);



            // Create Transaction
            $transaction = Transaction::create([

                'payment_id' => $payment->id,

                'transaction_id' =>
                    'TXN_PDZ_' . strtoupper(Str::random(16)),

                'provider' => 'MOCK',

                'provider_reference' =>
                    'MOCK_' . strtoupper(Str::random(12)),

                'amount' => $payment->amount,

                'currency' => $payment->currency,

                'status' => 'paid',

                'paid_at' => now(),

            ]);



            // Update payment status

            $payment->update([

                'status' => 'paid',

                'provider' => 'MOCK',

                'provider_reference' =>
                    $transaction->provider_reference,

            ]);



            // Return with transaction

            return $payment->load('transaction');

        });
    }




    /**
     * Get Payment
     */
    public function getPayment($paymentId)
    {
        return Payment::where('payment_id', $paymentId)
            ->with('transaction')
            ->firstOrFail();
    }




    /**
     * Update Payment Status
     */
    public function updateStatus($paymentId, $status)
    {
        $payment = Payment::where('payment_id', $paymentId)
            ->firstOrFail();


        $payment->update([
            'status' => $status
        ]);


        return $payment;
    }




    /**
     * Merchant Payments
     */
    public function merchantPayments($merchantId)
    {
        return Payment::where('merchant_id', $merchantId)
            ->with('transaction')
            ->latest()
            ->get();
    }

}
