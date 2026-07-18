<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;

use App\Models\PaymentLink;

use App\Services\PaymentLinkService;

use Illuminate\Http\Request;



class PaymentLinkController extends Controller
{


    public function __construct(
        protected PaymentLinkService $service
    ){}





    public function index()
    {

        return response()->json(

            PaymentLink::where(
                'merchant_id',
                auth()->user()->merchant->id
            )->latest()->get()

        );

    }





    public function store(Request $request)
    {


        $data=$request->validate([


            'title'=>'required|string',

            'description'=>'nullable|string',

            'amount'=>'required|numeric',

            'currency'=>'nullable|string',

            'max_payments'=>'nullable|integer',

            'expires_at'=>'nullable|date',


        ]);



        $link =
            $this->service->create($data);



        return response()->json([


            'message'=>'Payment link created',

            'link'=>$link,

            'url'=>$link->url()


        ],201);


    }





    public function show(
        PaymentLink $paymentLink
    )
    {

        return response()->json($paymentLink);

    }






    public function disable(
        PaymentLink $paymentLink
    )
    {

        return $this->service
            ->disable($paymentLink);

    }





    public function enable(
        PaymentLink $paymentLink
    )
    {

        return $this->service
            ->enable($paymentLink);

    }





    public function stats(
        PaymentLink $paymentLink
    )
    {

        return response()->json(

            $this->service
            ->stats($paymentLink)

        );

    }



}
