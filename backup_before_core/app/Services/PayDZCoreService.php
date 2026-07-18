<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use App\Models\Merchant;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class PayDZCoreService
{

    /*
    |--------------------------------------------------------------------------
    | CREATE PAYMENT
    |--------------------------------------------------------------------------
    */

    public function createPayment(array $data)
    {

        $payment = Payment::create([

            'merchant_id'=>$data['merchant_id'],

            'payment_id'=>$this->generatePaymentId(),

            'amount'=>$data['amount'],

            'currency'=>$data['currency'] ?? 'DZD',

            'customer_email'=>$data['customer_email'],

            'customer_name'=>$data['customer_name'] ?? null,

            'description'=>$data['description'] ?? null,

            'status'=>'pending',

        ]);


        // create transaction

        $transaction = Transaction::create([

            'payment_id'=>$payment->id,

            'transaction_id'=>$this->generateTransactionId(),

            'amount'=>$payment->amount,

            'currency'=>$payment->currency,

            'status'=>'pending',

        ]);



        return [
            'payment'=>$payment,
            'transaction'=>$transaction
        ];

    }




    /*
    |--------------------------------------------------------------------------
    | CHECKOUT
    |--------------------------------------------------------------------------
    */


    public function checkout($paymentId)
    {

        $payment = Payment::where(
            'payment_id',
            $paymentId
        )->firstOrFail();


        return [

            "payment_id"=>$payment->payment_id,

            "amount"=>$payment->amount,

            "currency"=>$payment->currency,

            "methods"=>[

                "CIB",
                "EDAHABIA",
                "BARIDIMOB"

            ]

        ];

    }





    /*
    |--------------------------------------------------------------------------
    | CONFIRM PAYMENT
    |--------------------------------------------------------------------------
    */


    public function confirmPayment($payment)
    {


        $payment->update([

            'status'=>'paid'

        ]);



        $transaction =
        Transaction::where(
            'payment_id',
            $payment->id
        )->first();



        if($transaction){

            $transaction->update([

                'status'=>'paid',

                'paid_at'=>now(),

                'provider'=>'PAYDZ',

                'provider_reference'=>
                $this->generateReference()

            ]);

        }



        // webhook

        $this->sendWebhook(
            $payment->merchant_id,
            [
                "event"=>"payment.success",
                "payment_id"=>$payment->payment_id,
                "amount"=>$payment->amount
            ]
        );



        return $payment;

    }





    /*
    |--------------------------------------------------------------------------
    | API KEYS
    |--------------------------------------------------------------------------
    */


    public function generateApiKey($merchant)
    {


        $key =
        "pk_live_".
        Str::random(32);



        $merchant->update([

            'api_key'=>Hash::make($key)

        ]);



        return $key;

    }





    /*
    |--------------------------------------------------------------------------
    | WEBHOOKS
    |--------------------------------------------------------------------------
    */


    public function sendWebhook($merchantId,$payload)
    {


        // لاحقا نضيف HTTP Client

        return [

            "merchant"=>$merchantId,

            "payload"=>$payload,

            "status"=>"sent"

        ];

    }





    /*
    |--------------------------------------------------------------------------
    | MERCHANT DASHBOARD
    |--------------------------------------------------------------------------
    */


    public function dashboard($merchantId)
    {


        return [

            "payments"=>Payment::where(
                'merchant_id',
                $merchantId
            )->count(),


            "transactions"=>Transaction::whereHas(
                'payment',
                function($q) use($merchantId){

                    $q->where(
                    'merchant_id',
                    $merchantId);

                }
            )->count(),


            "total"=>Payment::where(
                'merchant_id',
                $merchantId
            )
            ->where(
                'status',
                'paid'
            )
            ->sum('amount')

        ];

    }





    /*
    |--------------------------------------------------------------------------
    | GENERATORS
    |--------------------------------------------------------------------------
    */


    private function generatePaymentId()
    {

        return "pi_PDZ_".
        strtoupper(
            Str::random(20)
        );

    }



    private function generateTransactionId()
    {

        return "TXN_PDZ_".
        strtoupper(
            Str::random(20)
        );

    }



    private function generateReference()
    {

        return "REF_".
        strtoupper(
            Str::random(15)
        );

    }



}
