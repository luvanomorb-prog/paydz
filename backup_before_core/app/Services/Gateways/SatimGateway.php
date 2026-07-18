<?php

namespace App\Services\Gateways;

use App\Models\Payment;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class SatimGateway implements PaymentGatewayInterface
{


    protected string $baseUrl;
    protected string $merchantId;
    protected string $password;



    public function __construct()
    {

        $this->baseUrl =
            config('services.satim.base_url');


        $this->merchantId =
            config('services.satim.merchant_id');


        $this->password =
            config('services.satim.password');

    }




    public function charge(
        Payment $payment
    ): array
    {

        try {


            $response = Http::asForm()->post(

                $this->baseUrl.'/register.do',

                [

                    'userName'=>$this->merchantId,

                    'password'=>$this->password,


                    'orderNumber'=>
                        $payment->transaction_id,


                    'amount'=>
                        (int)($payment->amount * 100),


                    'currency'=>'012',


                    'returnUrl'=>
                        config('app.url')
                        .'/api/satim/callback',


                    'description'=>
                        $payment->description
                        ??
                        'PayDZ Payment'


                ]

            );




            $data = $response->json();



            if(
                !$response->successful()
            ){

                return [

                    'success'=>false,

                    'status'=>'failed',

                    'error_message'=>
                        'SATIM connection error'

                ];

            }





            if(
                isset($data['errorCode'])
                &&
                $data['errorCode'] !== '0'
            ){

                return [

                    'success'=>false,

                    'status'=>'failed',

                    'error_message'=>
                        $data['errorMessage']
                        ??
                        'SATIM rejected request',

                    'raw_response'=>$data

                ];

            }




            return [

                'success'=>true,


                'status'=>'requires_action',


                'gateway_reference'=>
                    $data['orderId'] ?? null,


                'redirect_url'=>
                    $data['formUrl'] ?? null,


                'raw_response'=>$data


            ];



        }
        catch(\Throwable $e)
        {


            Log::error(
                'SATIM ERROR',
                [
                    'error'=>$e->getMessage()
                ]
            );



            return [

                'success'=>false,

                'status'=>'failed',

                'error_message'=>
                    'SATIM exception'

            ];

        }

    }






    public function verify(
        string $gatewayReference
    ): array
    {


        $response = Http::asForm()->post(

            $this->baseUrl.'/getOrderStatusExtended.do',

            [

                'userName'=>$this->merchantId,

                'password'=>$this->password,

                'orderId'=>$gatewayReference

            ]

        );



        $data=$response->json();



        $success =
            ($data['OrderStatus'] ?? null)==2;



        return [

            'success'=>$success,

            'status'=>
                $success
                ?
                'paid'
                :
                'failed',

            'gateway_reference'=>
                $gatewayReference,

            'raw_response'=>$data

        ];

    }







    public function refund(
        Payment $payment,
        ?float $amount=null
    ): array
    {

        return [

            'success'=>false,

            'status'=>'failed',

            'error_message'=>
                'Refund unavailable'

        ];

    }






    public function getName(): string
    {

        return 'satim';

    }


}
