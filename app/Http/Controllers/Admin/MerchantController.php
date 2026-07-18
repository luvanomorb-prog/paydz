<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use App\Models\Merchant;

use Illuminate\Http\Request;



class MerchantController extends Controller
{


    /**
     * Merchants list
     */
    public function index(Request $request)
    {


        $query = Merchant::query()
            ->with('user');



        if($request->search){


            $query->where(function($q) use($request){


                $q->where(
                    'business_name',
                    'like',
                    '%'.$request->search.'%'
                )


                ->orWhere(
                    'business_email',
                    'like',
                    '%'.$request->search.'%'
                );


            });


        }




        $merchants = $query

            ->latest()

            ->paginate(10)

            ->withQueryString();





        return inertia(
            'Admin/Merchants/Index',
            [

                'merchants'=>$merchants,

                'filters'=>[

                    'search'=>$request->search

                ]

            ]
        );


    }







    /**
     * Verify merchant
     */
    public function verify(Merchant $merchant)
    {


        $merchant->update([


            'status'=>'verified',


            'kyc_verified'=>true


        ]);



        return back()
            ->with(
                'success',
                'Merchant verified successfully'
            );


    }







    /**
     * Reject merchant
     */
    public function reject(Merchant $merchant)
    {


        $merchant->update([


            'status'=>'rejected',


            'kyc_verified'=>false


        ]);



        return back()
            ->with(
                'success',
                'Merchant rejected'
            );


    }







    /**
     * Suspend merchant
     */
    public function suspend(Merchant $merchant)
    {


        $merchant->update([


            'status'=>'suspended'


        ]);



        return back()
            ->with(
                'success',
                'Merchant suspended'
            );


    }



}
