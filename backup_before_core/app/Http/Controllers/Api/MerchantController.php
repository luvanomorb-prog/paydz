<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Payment;
use App\Models\Transaction;


class MerchantController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | Merchant Dashboard
    |--------------------------------------------------------------------------
    */

    public function dashboard(Request $request)
    {

        $merchant_id = $request->merchant_id ?? 2;


        $merchant = Merchant::findOrFail($merchant_id);


        return response()->json([

            "merchant" => [

                "id"=>$merchant->id,

                "business_name"=>$merchant->business_name,

                "status"=>$merchant->status

            ],


            "statistics"=>[

                "total_payments"=>Payment::where(
                    'merchant_id',
                    $merchant_id
                )->count(),


                "total_transactions"=>Transaction::whereHas(
                    'payment',
                    function($q) use($merchant_id){

                        $q->where(
                            'merchant_id',
                            $merchant_id
                        );

                    }
                )->count(),


                "total_revenue"=>Payment::where(
                    'merchant_id',
                    $merchant_id
                )
                ->where(
                    'status',
                    'paid'
                )
                ->sum('amount')

            ]

        ]);

    }




    /*
    |--------------------------------------------------------------------------
    | Merchant Payments
    |--------------------------------------------------------------------------
    */


    public function payments(Request $request)
    {

        $merchant_id = $request->merchant_id ?? 2;


        $payments = Payment::where(
            'merchant_id',
            $merchant_id
        )
        ->latest()
        ->get();



        return response()->json([

            "data"=>$payments

        ]);

    }





    /*
    |--------------------------------------------------------------------------
    | Merchant Transactions
    |--------------------------------------------------------------------------
    */


    public function transactions(Request $request)
    {

        $merchant_id = $request->merchant_id ?? 2;



        $transactions = Transaction::whereHas(
            'payment',
            function($q) use($merchant_id){

                $q->where(
                    'merchant_id',
                    $merchant_id
                );

            }
        )
        ->latest()
        ->get();



        return response()->json([

            "data"=>$transactions

        ]);

    }


}
