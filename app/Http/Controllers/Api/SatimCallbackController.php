<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\GatewayManager;
use App\Services\TransactionService;
use App\Services\WebhookService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class SatimCallbackController extends Controller
{


    public function __construct(
        protected GatewayManager $gatewayManager,
        protected TransactionService $transactionService,
        protected WebhookService $webhookService
    ){}




    /**
     * SATIM callback
     */
    public function handle(Request $request)
    {


        Log::info(
            'SATIM CALLBACK',
            $request->all()
        );



        $gatewayReference =
            $request->input('orderId');



        if(!$gatewayReference)
        {

            return response()->json([

                'message'=>'Missing order id'

            ],422);

        }




        $payment = Payment::where(

            'provider_reference',

            $gatewayReference

        )->first();



        if(!$payment)
        {

            return response()->json([

                'message'=>'Payment not found'

            ],404);

        }





        $gateway = $this->gatewayManager->driver(

            $payment->method

        );




        $result = $gateway->verify(

            $gatewayReference

        );





        if($result['success'])
        {


            $payment->update([

                'status'=>'paid',

                'metadata'=>$result['raw_response'] ?? null

            ]);





            if(!$payment->transaction)
            {

                $this->transactionService
                    ->create($payment);

            }





            $transaction =
                $payment->transaction;



            if($transaction)
            {

                $this->transactionService
                    ->complete($transaction);

            }





            $this->webhookService->send(

                $payment->merchant,

                'payment.success',

                [

                    'payment_id'=>$payment->payment_id,

                    'amount'=>$payment->amount,

                    'currency'=>$payment->currency

                ]

            );



        }
        else
        {


            $payment->update([

                'status'=>'failed'

            ]);



        }




        return response()->json([

            'status'=>$payment->status

        ]);

    }



}
