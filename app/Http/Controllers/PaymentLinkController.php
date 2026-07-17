<?php

namespace App\Http\Controllers;

use App\Models\PaymentLink;
use App\Models\Merchant;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;


class PaymentLinkController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | Public Checkout Page
    |--------------------------------------------------------------------------
    */

    public function show($public_id)
    {

        $paymentLink = PaymentLink::where('public_id',$public_id)
            ->firstOrFail();


        // تعطيل الرابط
        if(!$paymentLink->active){

            abort(404,'Payment link disabled');

        }


        // انتهاء الصلاحية
        if(
            $paymentLink->expires_at &&
            Carbon::now()->greaterThan($paymentLink->expires_at)
        ){

            abort(404,'Payment link expired');

        }


        // زيادة عدد المشاهدات
        $paymentLink->increment('views_count');


        return inertia(
            'Checkout',
            [
                'paymentLink'=>$paymentLink
            ]
        );


    }





    /*
    |--------------------------------------------------------------------------
    | Merchant Create Payment Link
    |--------------------------------------------------------------------------
    */

    public function store(Request $request)
    {


        $validator = Validator::make($request->all(),[


            'title'=>'required|string|max:255',

            'description'=>'nullable|string',

            'amount'=>'required|numeric|min:1',

            'currency'=>'required|string|max:10',

            'max_payments'=>'nullable|integer|min:1',

            'expires_at'=>'nullable|date',


        ]);



        if($validator->fails()){


            return response()->json([

                'errors'=>$validator->errors()

            ],422);


        }





        $merchant = Auth::user()
            ->merchant;



        if(!$merchant){


            return response()->json([

                'message'=>'Merchant account required'

            ],403);


        }





        $paymentLink = PaymentLink::create([


            'merchant_id'=>$merchant->id,


            'public_id'=>
                'pl_'.Str::lower(Str::random(24)),


            'uuid'=>Str::uuid(),


            'title'=>$request->title,


            'description'=>$request->description,


            'amount'=>$request->amount,


            'currency'=>$request->currency,


            'active'=>true,


            'max_payments'=>$request->max_payments,


            'payments_count'=>0,


            'views_count'=>0,


            'revenue'=>0,


            'expires_at'=>$request->expires_at,


        ]);





        return response()->json([


            'message'=>'Payment link created successfully',


            'data'=>$paymentLink,


            'url'=>url(
                '/pay/'.$paymentLink->public_id
            )


        ],201);



    }





    /*
    |--------------------------------------------------------------------------
    | Merchant Payment Links List
    |--------------------------------------------------------------------------
    */

    public function index()
    {


        $merchant = Auth::user()
            ->merchant;



        $links = PaymentLink::where(
            'merchant_id',
            $merchant->id
        )
        ->latest()
        ->get();



        return response()->json([

            'data'=>$links

        ]);

    }






    /*
    |--------------------------------------------------------------------------
    | Single Link Details
    |--------------------------------------------------------------------------
    */

    public function apiShow(PaymentLink $paymentLink)
    {


        return response()->json([

            'data'=>$paymentLink

        ]);


    }







    /*
    |--------------------------------------------------------------------------
    | Disable Link
    |--------------------------------------------------------------------------
    */

    public function disable(PaymentLink $paymentLink)
    {


        $paymentLink->update([

            'active'=>false

        ]);



        return response()->json([


            'message'=>'Payment link disabled'


        ]);

    }






    /*
    |--------------------------------------------------------------------------
    | Enable Link
    |--------------------------------------------------------------------------
    */

    public function enable(PaymentLink $paymentLink)
    {


        $paymentLink->update([

            'active'=>true

        ]);



        return response()->json([


            'message'=>'Payment link enabled'


        ]);


    }








    /*
    |--------------------------------------------------------------------------
    | Link Statistics
    |--------------------------------------------------------------------------
    */

    public function stats(PaymentLink $paymentLink)
    {


        return response()->json([


            'views'=>
                $paymentLink->views_count,


            'payments'=>
                $paymentLink->payments_count,


            'revenue'=>
                $paymentLink->revenue,


            'status'=>
                $paymentLink->active
                    ? 'active'
                    : 'disabled'


        ]);


    }





}
