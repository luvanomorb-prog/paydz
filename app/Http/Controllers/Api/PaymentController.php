<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Services\GatewayManager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;



class PaymentController extends Controller
{


    public function __construct(
        protected GatewayManager $gatewayManager
    ){}




    /*
    |--------------------------------------------------------------------------
    | Start Payment
    |--------------------------------------------------------------------------
    |
    | عندما يضغط المشتري على زر الدفع
    |
    */

    public function pay(
        Request $request,
        Payment $payment
    )
    {


        /*
        |--------------------------------------------------------------------------
        | Check status
        |--------------------------------------------------------------------------
        */


        if(
            $payment->status !== 'pending'
        )
        {

            return response()->json([

                'message'=>'Payment already processed',

                'status'=>$payment->status

            ],422);

        }




        /*
        |--------------------------------------------------------------------------
        | Get Gateway
        |--------------------------------------------------------------------------
        */


        $gateway = $this->gatewayManager
            ->driver(
                $payment->method
            );





        /*
        |--------------------------------------------------------------------------
        | Send Payment Request
        |--------------------------------------------------------------------------
        */


        $result = $gateway->charge(
            $payment
        );






        /*
        |--------------------------------------------------------------------------
        | Payment Failed
        |--------------------------------------------------------------------------
        */


        if(
            !$result['success']
        )
        {


            $payment->update([


                'status'=>'failed',


                'provider'=>
                    $gateway->getName(),



                'metadata'=>[

                    'error'=>
                        $result['error_message'] ?? null

                ]


            ]);




            return response()->json([


                'message'=>'Payment failed',


                'data'=>$result



            ],422);


        }





        /*
        |--------------------------------------------------------------------------
        | Redirect payment page
        |--------------------------------------------------------------------------
        |
        | مثال:
        | Edahabia -> SATIM
        |
        */


        if(
            !empty($result['redirect_url'])
        )
        {


            $payment->update([


                'status'=>'requires_action',



                'provider'=>
                    $gateway->getName(),



                'provider_reference'=>
                    $result['gateway_reference'] ?? null,



                'metadata'=>
                    $result['raw_response'] ?? null


            ]);





            return response()->json([


                'status'=>'requires_action',



                'redirect_url'=>
                    $result['redirect_url'],



                'reference'=>
                    $result['gateway_reference'] ?? null



            ]);

        }







        /*
        |--------------------------------------------------------------------------
        | Instant payment
        |--------------------------------------------------------------------------
        |
        | BaridiMob / Mock
        |
        */


        DB::transaction(function() use(
            $payment,
            $gateway,
            $result
        ){

            $payment->update([


                'status'=>'paid',



                'provider'=>
                    $gateway->getName(),



                'provider_reference'=>
                    $result['gateway_reference'] ?? null



            ]);



        });






        return response()->json([


            'status'=>'paid',


            'message'=>'Payment completed successfully',



            'payment'=>$payment->fresh()



        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | Verify Payment
    |--------------------------------------------------------------------------
    */


    public function verify(
        Payment $payment
    )
    {


        if(
            !$payment->provider_reference
        )
        {

            return response()->json([

                'message'=>'Missing provider reference'

            ],422);

        }



        $gateway = $this->gatewayManager
            ->driver(
                $payment->method
            );




        $result = $gateway->verify(
            $payment->provider_reference
        );




        if(
            $result['success']
        )
        {

            $payment->update([

                'status'=>'paid'

            ]);

        }




        return response()->json([

            'status'=>$payment->status,

            'gateway'=>$result

        ]);

    }

}
