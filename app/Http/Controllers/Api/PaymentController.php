<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Resources\PaymentResource;
use App\Services\PaymentService;
use Illuminate\Http\Request;


class PaymentController extends Controller
{

    protected PaymentService $service;



    public function __construct(
        PaymentService $service
    )
    {
        $this->service = $service;
    }



    public function store(Request $request)
    {

        $data = $request->validate([

            'merchant_id'=>'required|exists:merchants,id',

            'customer_id'=>'nullable|exists:customers,id',

            'amount'=>'required|numeric|min:1',

            'currency'=>'nullable|string|max:3',

            'description'=>'nullable|string'

        ]);



        $payment =
            $this->service->createPayment($data);



        return new PaymentResource($payment);

    }



    public function show($id)
    {

        return new PaymentResource(
            $this->service->find($id)
        );

    }

}
