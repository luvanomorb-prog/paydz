<?php

namespace App\Services;

use App\Models\CheckoutSession;
use Illuminate\Support\Str;
use Carbon\Carbon;


class CheckoutService
{

    public function create(array $data)
    {

        return CheckoutSession::create([

            'merchant_id' => $data['merchant_id'],

            'payment_id' => $data['payment_id'],

            'session_id' =>
                'cs_' . Str::random(32),

            'product_name' =>
                $data['product_name'] ?? null,

            'description' =>
                $data['description'] ?? null,

            'success_url' =>
                $data['success_url'] ?? null,

            'cancel_url' =>
                $data['cancel_url'] ?? null,

            'status' => 'open',

            'expires_at' =>
                Carbon::now()->addHours(24),

        ]);

    }



    public function findBySession($session)
    {

        return CheckoutSession::where(
            'session_id',
            $session
        )->firstOrFail();

    }

}
