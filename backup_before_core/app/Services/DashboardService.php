<?php

namespace App\Services;

use App\Models\Merchant;
use App\Models\Payment;
use App\Models\Transaction;

class DashboardService
{
    public function getData(int $merchantId): array
    {
        $merchant = Merchant::findOrFail($merchantId);


        $payments = Payment::where('merchant_id', $merchant->id);


        $totalRevenue = (clone $payments)
            ->where('status', 'paid')
            ->sum('amount');


        $todayRevenue = Payment::where('merchant_id', $merchant->id)
            ->where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('amount');


        $totalPayments = (clone $payments)->count();


        $paidPayments = (clone $payments)
            ->where('status', 'paid')
            ->count();


        $pendingPayments = (clone $payments)
            ->where('status', 'pending')
            ->count();


        $failedPayments = (clone $payments)
            ->where('status', 'failed')
            ->count();



        /*
        |--------------------------------------------------------------------------
        | Revenue Chart Data
        |--------------------------------------------------------------------------
        */

        $revenueChart = Payment::where('merchant_id', $merchant->id)
            ->where('status', 'paid')
            ->selectRaw("DATE_FORMAT(created_at,'%Y-%m') as month, SUM(amount) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->get();


        $revenue = [

            'labels' => $revenueChart->pluck('month'),

            'values' => $revenueChart->pluck('total'),

        ];



        $recentTransactions = Transaction::where('merchant_id', $merchant->id)
            ->latest()
            ->take(10)
            ->get();



        return [

            'merchant' => $merchant,


            'stats' => [

                'today_revenue' => $todayRevenue,

                'total_revenue' => $totalRevenue,

                'total_payments' => $totalPayments,

                'paid_payments' => $paidPayments,

                'pending_payments' => $pendingPayments,

                'failed_payments' => $failedPayments,

            ],



            'revenue_chart' => $revenue,


            'recent_transactions' => $recentTransactions,

        ];
    }
}
