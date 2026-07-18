<?php

namespace App\Http\Controllers\Merchant;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use App\Models\MerchantDocument;





class KycController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | KYC Page
    |--------------------------------------------------------------------------
    */


    public function index()
    {


        $merchant = Auth::user()
            ->merchant;



        $documents = $merchant
            ->documents()
            ->latest()
            ->get();



        return inertia(
            'Merchant/KYC/Index',
            [

                'documents'=>$documents,

                'merchant'=>$merchant

            ]
        );


    }









    /*
    |--------------------------------------------------------------------------
    | Upload Document
    |--------------------------------------------------------------------------
    */


    public function store(Request $request)
    {


        $merchant = Auth::user()
            ->merchant;





        if(!$merchant){

            abort(403);

        }







        $request->validate([


            'type'=>
            'required|string|max:100',



            'document'=>
            'required|file|mimes:pdf,jpg,jpeg,png|max:5120'


        ]);








        $exists = $merchant
            ->documents()
            ->where('type',$request->type)
            ->whereIn(
                'status',
                [
                    'pending',
                    'approved'
                ]
            )
            ->exists();






        if($exists){


            return back()
                ->with(
                    'error',
                    'This document already exists'
                );


        }









        $path = $request
            ->file('document')
            ->store(
                'kyc/'.$merchant->id,
                'local'
            );









        MerchantDocument::create([


            'merchant_id'=>$merchant->id,


            'type'=>$request->type,


            'file_path'=>$path,


            'status'=>'pending'


        ]);







        return back()->with(

            'success',

            'Document uploaded successfully'

        );


    }





}
