<?php

namespace App\Services\Dashboard;

use App\Models\Merchant;
use App\Models\Payment;
use App\Models\PaymentLink;
use App\Models\Transaction;

class DashboardService
{
    public function stats(Merchant $merchant): array
    {
        $payments = Payment::where('merchant_id', $merchant->id);

        $totalPayments = (clone $payments)->count();

        $successfulPayments = (clone $payments)
            ->where('status', 'paid')
            ->count();

        $failedPayments = (clone $payments)
            ->where('status', 'failed')
            ->count();

        $pendingPayments = (clone $payments)
            ->where('status', 'pending')
            ->count();

        $totalRevenue = (clone $payments)
            ->where('status', 'paid')
            ->sum('amount');

        $todayRevenue = (clone $payments)
            ->where('status', 'paid')
            ->whereDate('created_at', today())
            ->sum('amount');

        $successRate = $totalPayments > 0
            ? round(($successfulPayments / $totalPayments) * 100, 2)
            : 0;

        return [

            'stats' => [

                'today_revenue' => $todayRevenue,

                'total_revenue' => $totalRevenue,

                'total_payments' => $totalPayments,

                'successful_payments' => $successfulPayments,

                'pending_payments' => $pendingPayments,

                'failed_payments' => $failedPayments,

                'success_rate' => $successRate,

                'payment_links' => PaymentLink::where('merchant_id', $merchant->id)->count(),

                'transactions' => Transaction::where('merchant_id', $merchant->id)->count(),

            ],

            'recent_payments' => Payment::where('merchant_id', $merchant->id)
                ->latest()
                ->take(10)
                ->get(),

            'recent_transactions' => Transaction::where('merchant_id', $merchant->id)
                ->latest()
                ->take(10)
                ->get(),

        ];
    }
}
