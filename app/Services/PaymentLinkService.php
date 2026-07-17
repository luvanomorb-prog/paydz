<?php

namespace App\Services;


use App\Models\PaymentLink;
use Illuminate\Support\Facades\Auth;



class PaymentLinkService
{


    public function create(array $data)
    {

        return PaymentLink::create([


            'merchant_id'=>Auth::user()->merchant->id,


            'title'=>$data['title'],

            'description'=>$data['description'] ?? null,


            'amount'=>$data['amount'],


            'currency'=>$data['currency'] ?? 'DZD',


            'max_payments'=>$data['max_payments'] ?? null,


            'expires_at'=>$data['expires_at'] ?? null,


            'collect_name'=>$data['collect_name'] ?? false,


            'collect_email'=>$data['collect_email'] ?? false,


            'collect_phone'=>$data['collect_phone'] ?? false,


            'success_url'=>$data['success_url'] ?? null,


            'cancel_url'=>$data['cancel_url'] ?? null,


            'metadata'=>$data['metadata'] ?? null,


            'active'=>true


        ]);

    }




    public function disable(
        PaymentLink $link
    )
    {

        $link->update([

            'active'=>false

        ]);

        return $link;

    }





    public function enable(
        PaymentLink $link
    )
    {

        $link->update([

            'active'=>true

        ]);


        return $link;

    }




    public function stats(
        PaymentLink $link
    )
    {

        return [

            'views'=>$link->views_count,

            'payments'=>$link->payments_count,

            'revenue'=>$link->revenue,


        ];

    }



}
