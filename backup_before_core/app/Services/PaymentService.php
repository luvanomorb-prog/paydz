<?php

namespace App\Services;


use App\Models\Payment;
use App\Models\Merchant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;



class PaymentService
{


    public function __construct(

        protected PaymentProcessor $processor

    ){}





    /*
    |--------------------------------------------------------------------------
    | Create Payment
    |--------------------------------------------------------------------------
    */


    public function createPayment(array $data)
    {


        return DB::transaction(function () use ($data) {


            $merchant = Merchant::findOrFail(
                $data['merchant_id']
            );





            $payment = Payment::create([


                'merchant_id'=>$merchant->id,


                'payment_id'=>
                    'pi_PDZ_' .
                    strtoupper(Str::random(18)),


                'amount'=>$data['amount'],


                'currency'=>
                    $data['currency'] ?? 'DZD',



                'customer_email'=>
                    $data['customer_email'],



                'customer_name'=>
                    $data['customer_name'] ?? null,



                'description'=>
                    $data['description'] ?? null,



                'status'=>'pending',



                'metadata'=>
                    $data['metadata'] ?? null


            ]);







            /*
            |--------------------------------------------------------------------------
            | Process Payment
            |--------------------------------------------------------------------------
            */


            $this->processor
                ->process($payment);






            return $payment
                ->fresh()
                ->load('transaction');



        });


    }









    /*
    |--------------------------------------------------------------------------
    | Get Payment
    |--------------------------------------------------------------------------
    */


    public function getPayment($paymentId)
    {


        return Payment::where(
                'payment_id',
                $paymentId
            )
            ->with('transaction')
            ->firstOrFail();


    }









    /*
    |--------------------------------------------------------------------------
    | Update Status
    |--------------------------------------------------------------------------
    */


    public function updateStatus(
        $paymentId,
        $status
    )
    {


        $payment = Payment::where(
            'payment_id',
            $paymentId
        )
        ->firstOrFail();




        $payment->update([

            'status'=>$status

        ]);



        return $payment;



    }









    /*
    |--------------------------------------------------------------------------
    | Merchant Payments
    |--------------------------------------------------------------------------
    */


    public function merchantPayments(
        $merchantId
    )
    {


        return Payment::where(
                'merchant_id',
                $merchantId
            )
            ->with('transaction')
            ->latest()
            ->get();



    }



}
