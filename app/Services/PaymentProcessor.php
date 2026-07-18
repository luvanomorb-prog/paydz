<?php

namespace App\Services;


use App\Models\Payment;
use App\Services\TransactionService;
use App\Services\PaymentStateMachine;
use App\Services\WebhookService;
use Illuminate\Support\Facades\Log;
use Exception;



class PaymentProcessor
{


    public function __construct(

        protected GatewayManager $gateway,

        protected PaymentStateMachine $stateMachine,

        protected TransactionService $transactionService,

        protected WebhookService $webhookService

    ){}





    /*
    |--------------------------------------------------------------------------
    | Process Payment
    |--------------------------------------------------------------------------
    */


    public function process(
        Payment $payment
    ): Payment
    {


        try {


            /*
            |--------------------------------------------------------------------------
            | Move to processing
            |--------------------------------------------------------------------------
            */


            if(
                $payment->status === 'pending'
            ){

                $this->stateMachine
                    ->transition(
                        $payment,
                        'processing'
                    );

            }






            /*
            |--------------------------------------------------------------------------
            | Execute Gateway
            |--------------------------------------------------------------------------
            */


            $result = $this->gateway
                ->get()
                ->charge($payment);







            if(
                $result['success'] ?? false
            ){


                /*
                |--------------------------------------------------------------------------
                | Payment Success
                |--------------------------------------------------------------------------
                */


                $this->stateMachine
                    ->transition(
                        $payment,
                        'paid'
                    );




                $this->transactionService
                    ->createFromPayment($payment);





                $this->webhookService
                    ->send(
                        $payment,
                        'payment.paid'
                    );





            }
            else
            {


                /*
                |--------------------------------------------------------------------------
                | Payment Failed
                |--------------------------------------------------------------------------
                */


                $this->stateMachine
                    ->transition(
                        $payment,
                        'failed'
                    );




                $this->webhookService
                    ->send(
                        $payment,
                        'payment.failed'
                    );



            }






            return $payment->fresh();




        }
        catch(Exception $e)
        {


            Log::error(
                'Payment processing failed',
                [
                    'payment_id'=>$payment->id,
                    'error'=>$e->getMessage()
                ]
            );



            if(
                $payment->status === 'processing'
            ){

                $this->stateMachine
                    ->transition(
                        $payment,
                        'failed'
                    );

            }



            throw $e;


        }



    }




}
