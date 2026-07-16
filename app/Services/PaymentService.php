<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\Transaction;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class PaymentService
{

    public function create(array $data)
    {

        return DB::transaction(function () use ($data) {


            $payment = Payment::create([

                'merchant_id' => $data['merchant_id'],

                'payment_id' =>
                    'PDZ_' . strtoupper(Str::random(20)),

                'amount' =>
                    $data['amount'],

                'currency' =>
                    $data['currency'] ?? 'DZD',

                'customer_email' =>
                    $data['customer_email'] ?? null,

                'customer_name' =>
                    $data['customer_name'] ?? null,

                'description' =>
                    $data['description'] ?? null,

                'status' =>
                    'pending',

                'metadata' =>
                    $data['metadata'] ?? null,

            ]);



            Transaction::create([

                'payment_id' =>
                    $payment->id,

                'transaction_id' =>
                    'TRX_' . strtoupper(Str::random(20)),

                'amount' =>
                    $payment->amount,

                'currency' =>
                    $payment->currency,

                'status' =>
                    'pending',

            ]);



            return $payment->load('transaction');

        });

    }

}
