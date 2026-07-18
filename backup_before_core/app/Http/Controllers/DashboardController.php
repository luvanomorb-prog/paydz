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
            ->firstOrFail();



        $paymentsQuery = Payment::where('merchant_id', $merchant->id);



        /*
        |--------------------------------------------------------------------------
        | Payments Pagination
        |--------------------------------------------------------------------------
        */

        $payments = (clone $paymentsQuery)
            ->latest()
            ->paginate(10)
            ->withQueryString();



        /*
        |--------------------------------------------------------------------------
        | Transactions Pagination
        |--------------------------------------------------------------------------
        */

        $transactions = Transaction::where('merchant_id', $merchant->id)
            ->latest()
            ->paginate(10)
            ->withQueryString();




        $totalPayments = (clone $paymentsQuery)
            ->count();



        $paidPayments = (clone $paymentsQuery)
            ->where('status','paid')
            ->count();



        $pendingPayments = (clone $paymentsQuery)
            ->where('status','pending')
            ->count();



        $failedPayments = (clone $paymentsQuery)
            ->where('status','failed')
            ->count();



        $revenue = (clone $paymentsQuery)
            ->where('status','paid')
            ->sum('amount');




        /*
        |--------------------------------------------------------------------------
        | Revenue Chart
        |--------------------------------------------------------------------------
        */

        $revenueChart = Payment::where('merchant_id',$merchant->id)
            ->where('status','paid')
            ->selectRaw("DATE_FORMAT(created_at,'%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();



        $chart = [

            'labels'=>$revenueChart->pluck('month'),

            'values'=>$revenueChart->pluck('total'),

        ];




        return inertia('Dashboard',[


            'merchant'=>$merchant,



            'stats'=>[

                'payments'=>$totalPayments,

                'transactions'=>Transaction::where('merchant_id',$merchant->id)
                    ->count(),

                'revenue'=>$revenue,

                'paid_payments'=>$paidPayments,

                'pending_payments'=>$pendingPayments,

                'failed_payments'=>$failedPayments,

            ],



            'revenue_chart'=>$chart,



            'payments'=>$payments,



            'transactions'=>$transactions,


        ]);

    }
}
