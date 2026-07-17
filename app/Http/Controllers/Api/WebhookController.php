<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Merchant;
use App\Services\WebhookService;
use Illuminate\Http\Request;

class WebhookController extends Controller
{


    public function receive(
        Request $request,
        WebhookService $service
    )
    {


        $payload = $request->getContent();


        $signature = $request->header(
            'PayDZ-Signature'
        );


        $merchantId = $request->header(
            'PayDZ-Merchant'
        );


        if(!$merchantId || !$signature)
        {
            return response()->json([
                'message'=>'Missing signature'
            ],400);
        }



        $merchant = Merchant::find($merchantId);



        if(!$merchant)
        {
            return response()->json([
                'message'=>'Merchant not found'
            ],404);
        }



        $valid = $service->verify(
            $payload,
            $signature,
            $merchant->webhook_secret
        );



        if(!$valid)
        {
            return response()->json([
                'message'=>'Invalid signature'
            ],401);
        }




        $data = json_decode(
            $payload,
            true
        );



        /*
        BaridiMob payment confirmation
        */


        if(
            isset($data['event'])
            &&
            $data['event']=='payment.success'
        )
        {


            $paymentId =
                $data['data']['payment_id']
                ?? null;



            if($paymentId)
            {

                $payment = Payment::find(
                    $paymentId
                );


                if($payment)
                {

                    $payment->update([

                        'status'=>'paid'

                    ]);

                }

            }

        }



        return response()->json([

            'received'=>true

        ]);

    }



}
