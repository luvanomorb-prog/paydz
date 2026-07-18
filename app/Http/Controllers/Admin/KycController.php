<?php

namespace App\Http\Controllers\Admin;


use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Storage;

use App\Models\MerchantDocument;





class KycController extends Controller
{


    /*
    |--------------------------------------------------------------------------
    | KYC Documents List
    |--------------------------------------------------------------------------
    */


    public function index()
    {


        $documents = MerchantDocument::with([
            'merchant.user'
        ])
        ->latest()
        ->paginate(15);



        return inertia(
            'Admin/KYC/Index',
            [

                'documents'=>$documents

            ]
        );


    }









    /*
    |--------------------------------------------------------------------------
    | Secure View Document
    |--------------------------------------------------------------------------
    */


    public function view(
        MerchantDocument $document
    )
    {


        $path = $document->file_path;



        if(
            !$path ||
            !Storage::disk('local')->exists($path)
        ){

            abort(404);

        }



        return Storage::disk('local')
            ->response($path);


    }









    /*
    |--------------------------------------------------------------------------
    | Approve Document
    |--------------------------------------------------------------------------
    */


    public function approve(
        MerchantDocument $document
    )
    {



        $document->update([


            'status'=>'approved',


            'reviewed_by'=>Auth::id(),


            'reviewed_at'=>now()


        ]);






        $merchant = $document->merchant;





        $pending = $merchant
            ->documents()
            ->where('status','pending')
            ->count();





        $rejected = $merchant
            ->documents()
            ->where('status','rejected')
            ->count();







        if(
            $pending === 0
            &&
            $rejected === 0
        ){


            $merchant->update([


                'kyc_verified'=>true,


                'status'=>'verified'


            ]);


        }






        return back()->with(

            'success',

            'Document approved successfully'

        );


    }









    /*
    |--------------------------------------------------------------------------
    | Reject Document
    |--------------------------------------------------------------------------
    */


    public function reject(
        Request $request,
        MerchantDocument $document
    )
    {



        $request->validate([


            'reason'=>'required|string|max:500'


        ]);







        $document->update([


            'status'=>'rejected',


            'reviewed_by'=>Auth::id(),


            'reviewed_at'=>now(),


            'rejection_reason'=>$request->reason


        ]);







        $document->merchant->update([


            'kyc_verified'=>false,


            'status'=>'pending'


        ]);







        return back()->with(

            'success',

            'Document rejected'

        );


    }





}
