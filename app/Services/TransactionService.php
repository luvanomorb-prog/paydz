<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class TransactionService
{


    /**
     * إنشاء Transaction جديدة
     */
    public function create(Payment $payment)
    {

        return DB::transaction(function () use ($payment) {


            $transaction = Transaction::create([

                'merchant_id' => $payment->merchant_id,

                'payment_id' => $payment->id,

                'type' => 'payment',

                'amount' => $payment->amount,

                'currency' => $payment->currency,

                'status' => 'pending',

                'reference' =>
                    'TXN_' . strtoupper(Str::random(20))

            ]);


            return $transaction;


        });

    }




    /**
     * تأكيد الدفع
     */
    public function complete(Transaction $transaction)
    {

        return DB::transaction(function () use ($transaction) {


            $transaction->update([

                'status'=>'completed'

            ]);



            $payment = $transaction->payment;


            $payment->update([

                'status'=>'paid'

            ]);



            $merchant = $transaction->merchant;



            $merchant->increment(
                'payments_count'
            );


            $merchant->increment(
                'revenue',
                $transaction->amount
            );



            return $transaction;


        });

    }





    /**
     * فشل الدفع
     */
    public function fail(Transaction $transaction)
    {


        $transaction->update([

            'status'=>'failed'

        ]);



        $transaction->payment->update([

            'status'=>'failed'

        ]);



        return $transaction;


    }



}

