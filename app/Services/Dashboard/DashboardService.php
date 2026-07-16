<?php

namespace App\Services\Dashboard;

use App\Models\Merchant;
use App\Models\Payment;
use App\Models\Transaction;

class DashboardService
{
    public function stats(Merchant $merchant): array
    {
        $payments = Payment::where('merchant_id', $merchant->id);

        return [
            'total_payments' => $payments->count(),

            'successful_payments' => (clone $payments)
                ->where('status', 'paid')
                ->count(),

            'failed_payments' => (clone $payments)
                ->where('status', 'failed')
                ->count(),

            'pending_payments' => (clone $payments)
                ->where('status', 'pending')
                ->count(),

            'total_revenue' => (clone $payments)
                ->where('status', 'paid')
                ->sum('amount'),

            'today_revenue' => (clone $payments)
                ->where('status', 'paid')
                ->whereDate('created_at', today())
                ->sum('amount'),

            'transactions' => Transaction::whereHas('payment', function ($q) use ($merchant) {
                $q->where('merchant_id', $merchant->id);
            })->count(),
        ];
    }
}
