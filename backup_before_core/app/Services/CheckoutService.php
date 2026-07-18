<?php

namespace App\Services;

use App\Models\CheckoutSession;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;


class CheckoutService
{

    public function create(array $data)
    {

        return DB::transaction(function () use ($data) {


            $payment = Payment::findOrFail(
                $data['payment_id']
            );


            $session = CheckoutSession::create([

                'merchant_id' =>
                    $payment->merchant_id,

                'payment_id' =>
                    $payment->id,

                'session_id' =>
                    'cs_' . Str::random(32),

                'product_name' =>
                    $data['product_name'] ?? 
                    $payment->description,

                'description' =>
                    $payment->description,

                'success_url' =>
                    $data['success_url'] ?? null,

                'cancel_url' =>
                    $data['cancel_url'] ?? null,

                'status' =>
                    'open',

                'expires_at' =>
                    Carbon::now()->addHours(24),

            ]);


            return $session;

        });

    }



    public function find($session)
    {

        return CheckoutSession::with([
            'payment',
            'merchant'
        ])
        ->where(
            'session_id',
            $session
        )
        ->firstOrFail();

    }

}
