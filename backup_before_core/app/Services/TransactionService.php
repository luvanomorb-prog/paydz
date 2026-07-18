<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;


class TransactionService
{


    /**
     * Create transaction from payment
     */
    public function create(Payment $payment): Transaction
    {

        return DB::transaction(function () use ($payment) {


            return Transaction::create([

                'merchant_id' => $payment->merchant_id,

                'payment_id' => $payment->id,

                'type' => 'payment',

                'amount' => $payment->amount,

                'currency' => $payment->currency,

                'status' => 'pending',

                'reference' =>
                    'TXN_' .
                    strtoupper(Str::random(20))

            ]);


        });

    }




    /**
     * Mark transaction as paid
     */
    public function complete(Transaction $transaction)
    {

        return DB::transaction(function () use ($transaction) {


            $transaction->update([

                'status'=>'paid',

                'paid_at'=>now()

            ]);



            $payment = $transaction->payment;



            $payment->update([

                'status'=>'paid',

                'provider_reference'=>
                    $transaction->gateway_reference

            ]);



            return $transaction->fresh();


        });

    }





    /**
     * Mark transaction failed
     */
    public function fail(
        Transaction $transaction,
        ?string $reason=null
    )
    {


        return DB::transaction(function () use (
            $transaction,
            $reason
        ) {


            $transaction->update([

                'status'=>'failed',

                'failure_reason'=>$reason

            ]);



            $transaction->payment->update([

                'status'=>'failed'

            ]);



            return $transaction->fresh();


        });


    }



}
