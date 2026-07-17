<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{

    protected PaymentService $paymentService;


    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }



    /**
     * Create Payment
     */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [

            'merchant_id' => [
                'required',
                'exists:merchants,id'
            ],

            'amount' => [
                'required',
                'numeric',
                'min:1'
            ],

            'currency' => [
                'nullable',
                'string'
            ],

            'customer_email' => [
                'required',
                'email'
            ],

            'customer_name' => [
                'nullable',
                'string'
            ],

            'description' => [
                'nullable',
                'string'
            ],

        ]);



        if ($validator->fails()) {

            return response()->json([

                'message' => 'Validation error',

                'errors' => $validator->errors()

            ],422);

        }



        $payment = $this->paymentService
            ->createPayment($request->all());



        return response()->json([

            'data' => [

                'id' => $payment->id,


                'payment_intent_id' =>
                    $payment->payment_id,


                'amount' =>
                    $payment->amount,


                'currency' =>
                    $payment->currency,


                'status' =>
                    $payment->status,


                'description' =>
                    $payment->description,


                'transaction' => [

                    'id' =>
                        $payment->transaction?->id,


                    'reference' =>
                        $payment->transaction?->transaction_id,


                ],


                'created_at' =>
                    $payment->created_at,

            ]

        ],201);

    }




    /**
     * Show Payment
     */
    public function show($paymentId)
    {

        $payment = $this->paymentService
            ->getPayment($paymentId);



        return response()->json([

            'data' => $payment

        ]);

    }




    /**
     * Update Status
     */
    public function updateStatus(Request $request,$paymentId)
    {

        $validator = Validator::make($request->all(), [

            'status' => [
                'required',
                'string'
            ]

        ]);



        if($validator->fails()){

            return response()->json([

                'errors'=>$validator->errors()

            ],422);

        }



        $payment = $this->paymentService
            ->updateStatus(
                $paymentId,
                $request->status
            );



        return response()->json([

            'data'=>$payment

        ]);

    }



}
