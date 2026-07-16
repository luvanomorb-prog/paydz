<?php

namespace App\Services;

use App\Models\Merchant;
use App\Models\Payment;
use App\Models\Transaction;

class DashboardService
{
    public function getData(int $userId): array
    {
        $merchant = Merchant::where('user_id', $userId)
            ->firstOrFail();

        $payments = Payment::where('merchant_id', $merchant->id)
            ->latest()
            ->take(10)
            ->get();

        $stats = [
            'payments' => Payment::where('merchant_id', $merchant->id)->count(),

            'transactions' => Transaction::whereHas('payment', function ($query) use ($merchant) {
                $query->where('merchant_id', $merchant->id);
            })->count(),

            'revenue' => Payment::where('merchant_id', $merchant->id)
                ->where('status', 'paid')
                ->sum('amount'),

            'pending' => Payment::where('merchant_id', $merchant->id)
                ->where('status', 'pending')
                ->count(),
        ];

        return [
            'merchant' => $merchant,
            'payments' => $payments,
            'stats' => $stats,
        ];
    }
}
