<?php

namespace App\Services\Payment;

use App\Models\Merchant;
use App\Models\Payment;
use Illuminate\Support\Str;

class PaymentService
{
    public function create(Merchant $merchant, array $data): Payment
    {
        return Payment::create([
            'merchant_id' => $merchant->id,

            'payment_id' => 'PDZ_' . strtoupper(Str::random(20)),

            'amount' => $data['amount'],

            'currency' => $data['currency'] ?? 'DZD',

            'customer_email' => $data['customer_email'],

            'customer_name' => $data['customer_name'] ?? null,

            'description' => $data['description'] ?? null,

            'status' => 'pending',

            'metadata' => $data['metadata'] ?? null,
        ]);
    }
}
