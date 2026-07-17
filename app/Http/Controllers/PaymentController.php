<?php

namespace App\Http\Controllers;


use App\Models\Payment;
use App\Models\PaymentLink;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;



class PaymentController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | Dashboard Payments
    |--------------------------------------------------------------------------
    */
    public function index()
    {

        $payments = Payment::with([
            'paymentLink',
            'merchant'
        ])
        ->latest()
        ->paginate(20);



        return Inertia::render(
            'Payments/Index',
            [
                'payments'=>$payments
            ]
        );

    }





    /*
    |--------------------------------------------------------------------------
    | Show Payment
    |--------------------------------------------------------------------------
    */
    public function show(Payment $payment)
    {

        return Inertia::render(
            'Payments/Show',
            [
                'payment'=>$payment
            ]
        );

    }






    /*
    |--------------------------------------------------------------------------
    | Process Checkout Payment
    |--------------------------------------------------------------------------
    */
    public function process(
        Request $request,
        PaymentLink $paymentLink
    )
    {


        $payment = Payment::create([

            'payment_link_id'=>$paymentLink->id,

            'merchant_id'=>$paymentLink->merchant_id,

            'amount'=>$paymentLink->amount,

            'currency'=>$paymentLink->currency,

            'method'=>$request->method,

            'status'=>'pending',

            'transaction_id'=>'TX-'
            .strtoupper(Str::random(12))

        ]);





        if($request->method === 'baridimob')
        {

            return redirect()->route(
                'payment.success',
                $payment->id
            );

        }





        if($request->method === 'cib')
        {

            return redirect()->route(
                'payment.success',
                $payment->id
            );

        }



        return back();

    }





    /*
    |--------------------------------------------------------------------------
    | Success
    |--------------------------------------------------------------------------
    */
    public function success(Payment $payment)
    {


        $payment->update([

            'status'=>'paid'

        ]);



        $payment->paymentLink()
            ->increment(
                'payments_count'
            );



        $payment->paymentLink()
            ->increment(
                'revenue',
                $payment->amount
            );



        return "Payment Successful";

    }





    /*
    |--------------------------------------------------------------------------
    | Cancel
    |--------------------------------------------------------------------------
    */
    public function cancel(Payment $payment)
    {

        $payment->update([

            'status'=>'cancelled'

        ]);


        return "Payment Cancelled";

    }




}
