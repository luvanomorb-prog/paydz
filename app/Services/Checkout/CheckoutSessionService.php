<?php

namespace App\Services\Checkout;


use App\Models\CheckoutSession;
use App\Models\Merchant;
use App\Models\Payment;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;



class CheckoutSessionService
{


    /*
    |--------------------------------------------------------------------------
    | Create Checkout Session
    |--------------------------------------------------------------------------
    */


    public function create(array $data): CheckoutSession
    {


        return DB::transaction(function () use ($data) {


            $merchant = Merchant::findOrFail(
                $data['merchant_id']
            );



            $sessionId = 'cs_PDZ_' .
                strtoupper(
                    Str::random(24)
                );




            /*
            |--------------------------------------------------------------------------
            | Create Payment
            |--------------------------------------------------------------------------
            */


            $payment = Payment::create([


                'merchant_id' => $merchant->id,


                'transaction_id' =>
                    'TXN_PDZ_' .
                    strtoupper(
                        Str::random(16)
                    ),



                'amount' =>
                    $data['amount'],



                'currency' =>
                    $data['currency'] ?? 'DZD',



                'customer_name' =>
                    $data['customer_name'] ?? null,



                'customer_email' =>
                    $data['customer_email'] ?? null,



                'method'=>
                    $data['payment_method'] ?? 'baridimob',


                'status' =>
                    'pending',



                'metadata' =>
                    $data['metadata'] ?? null



            ]);







            /*
            |--------------------------------------------------------------------------
            | Create Checkout Session
            |--------------------------------------------------------------------------
            */


            $session = CheckoutSession::create([



                'merchant_id' =>
                    $merchant->id,



                'payment_id' =>
                    $payment->id,



                'session_id' =>
                    $sessionId,



                'customer_name' =>
                    $data['customer_name'] ?? null,



                'customer_email' =>
                    $data['customer_email'] ?? null,



                'amount' =>
                    $data['amount'],



                'currency' =>
                    $data['currency'] ?? 'DZD',



                'status' =>
                    'open',



                'success_url' =>
                    $data['success_url'] ?? null,



                'cancel_url' =>
                    $data['cancel_url'] ?? null,



                'metadata' =>
                    $data['metadata'] ?? null



            ]);




            return $session->load('payment');


        });


    }








    /*
    |--------------------------------------------------------------------------
    | Find Session
    |--------------------------------------------------------------------------
    */


    public function find(string $sessionId)
    {


        return CheckoutSession::where(
                'session_id',
                $sessionId
            )
            ->with([
                'merchant',
                'payment'
            ])
            ->firstOrFail();


    }








    /*
    |--------------------------------------------------------------------------
    | Complete Session
    |--------------------------------------------------------------------------
    */


    public function complete(
        CheckoutSession $session
    )
    {


        $session->update([

            'status'=>'completed'

        ]);



        $session->payment?->update([

            'status'=>'paid'

        ]);



        return $session->fresh([
            'payment'
        ]);


    }



}
