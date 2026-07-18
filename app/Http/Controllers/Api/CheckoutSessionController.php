<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

use App\Services\Checkout\CheckoutSessionService;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;



class CheckoutSessionController extends Controller
{


    public function __construct(
        protected CheckoutSessionService $checkoutService
    ){}





    /*
    |--------------------------------------------------------------------------
    | Create Checkout Session
    |--------------------------------------------------------------------------
    */


    public function store(Request $request)
    {


        $validator = Validator::make(
            $request->all(),
            [

                'merchant_id'=>[
                    'required',
                    'exists:merchants,id'
                ],


                'amount'=>[
                    'required',
                    'numeric',
                    'min:1'
                ],


                'currency'=>[
                    'nullable',
                    'string'
                ],
                   'payment_method'=>[
                   'required',
                   'in:cib,edahabia,baridimob'
                ],

                'customer_email'=>[
                    'nullable',
                    'email'
                ],


                'customer_name'=>[
                    'nullable',
                    'string'
                ],


                'description'=>[
                    'nullable',
                    'string'
                ],


                'success_url'=>[
                    'nullable',
                    'string'
                ],


                'cancel_url'=>[
                    'nullable',
                    'string'
                ]

            ]
        );





        if($validator->fails())
        {

            return response()->json([

                'message'=>'Validation error',

                'errors'=>$validator->errors()

            ],422);

        }







        $session = $this->checkoutService
            ->create(
                $request->all()
            );








        return response()->json([


            'data'=>[


                'id'=>$session->id,


                'session_id'=>
                    $session->session_id,



                'status'=>
                    $session->status,



                'amount'=>
                    $session->amount,



                'currency'=>
                    $session->currency,



                'payment'=>[


                    'id'=>
                        $session->payment?->id,


                    'payment_id'=>
                        $session->payment?->payment_id,


                    'status'=>
                        $session->payment?->status


                ],



                'checkout_url'=>
                    url(
                        '/checkout/' .
                        $session->session_id
                    )

            ]


        ],201);



    }









    /*
    |--------------------------------------------------------------------------
    | Show Session
    |--------------------------------------------------------------------------
    */


    public function show(string $sessionId)
    {


        $session =
            $this->checkoutService
                ->find($sessionId);




        return response()->json([

            'data'=>$session

        ]);

    }








    /*
    |--------------------------------------------------------------------------
    | Complete Payment
    |--------------------------------------------------------------------------
    */


    public function complete($sessionId)
    {


        $session =
            $this->checkoutService
                ->find($sessionId);



        $session =
            $this->checkoutService
                ->complete(
                    $session
                );




        return response()->json([

            'data'=>$session

        ]);

    }





}
