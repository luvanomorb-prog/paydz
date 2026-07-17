<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\Payment;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $user = auth()->user();


        $merchant = Merchant::where('user_id', $user->id)
            ->first();


        if (!$merchant) {

            return response()->json([
                'message'=>'Merchant account not found',
                'user_id'=>$user->id,
                'email'=>$user->email
            ],404);

        }


        $payments = Payment::where('merchant_id',$merchant->id)
            ->latest()
            ->limit(10)
            ->get();


        $transactions = Transaction::where('merchant_id',$merchant->id)
            ->latest()
            ->limit(10)
            ->get();



        return inertia('Dashboard',[
            
            'merchant'=>$merchant,

            'stats'=>[

                'payments'=>Payment::where('merchant_id',$merchant->id)->count(),

                'transactions'=>Transaction::where('merchant_id',$merchant->id)->count(),

                'revenue'=>Payment::where('merchant_id',$merchant->id)
                    ->where('status','paid')
                    ->sum('amount'),

            ],

            'payments'=>$payments,

            'transactions'=>$transactions

        ]);

    }
}
