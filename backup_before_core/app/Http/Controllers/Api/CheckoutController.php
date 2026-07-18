<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CheckoutSession;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CheckoutController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Legacy Checkout Endpoint
    |--------------------------------------------------------------------------
    */

    public function create(Request $request)
    {
        $request->validate([
            'merchant_id' => 'required|exists:merchants,id',
            'amount'      => 'required|numeric|min:1',
            'currency'    => 'required|string|max:3',
        ]);

        return response()->json([
            'message' => 'Old checkout endpoint',
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Complete Checkout Payment
    |--------------------------------------------------------------------------
    */

    public function pay(Request $request, string $sessionId)
    {
        $request->validate([
'payment_method' => [
    'required',
    'exists:payment_methods,code'
],
        ]);

        return DB::transaction(function () use ($request, $sessionId) {

            $session = CheckoutSession::with([
                'payment',
                'merchant',
            ])
            ->where('session_id', $sessionId)
            ->lockForUpdate()
            ->firstOrFail();

            /*
            |--------------------------------------------------------------------------
            | Already Paid
            |--------------------------------------------------------------------------
            */

            if ($session->status === 'completed') {

                return response()->json([
                    'success' => true,
                    'message' => 'Payment already completed',
                    'data'    => $session,
                ]);
            }

            $payment = $session->payment;

            /*
            |--------------------------------------------------------------------------
            | Payment Gateway
            |--------------------------------------------------------------------------
            */

            $gateway = match ($request->payment_method) {

                'cib' => [
                    'provider' => 'SATIM',
                    'reference' => 'SATIM_' . strtoupper(Str::random(18)),
                ],

                'edahabia' => [
                    'provider' => 'SATIM',
                    'reference' => 'SATIM_' . strtoupper(Str::random(18)),
                ],

                'baridimob' => [
                    'provider' => 'BARIDIMOB',
                    'reference' => 'BMD_' . strtoupper(Str::random(18)),
                ],

                default => [
                    'provider' => 'MOCK',
                    'reference' => 'MOCK_' . strtoupper(Str::random(18)),
                ],
            };

            /*
            |--------------------------------------------------------------------------
            | Update Payment
            |--------------------------------------------------------------------------
            */

            $payment->update([

                'method' => $request->payment_method,

                'provider' => $gateway['provider'],

                'provider_reference' => $gateway['reference'],

                'transaction_id' => 'TXN_PDZ_' . strtoupper(Str::random(16)),

                'status' => 'paid',

            ]);

            /*
            |--------------------------------------------------------------------------
            | Update Checkout Session
            |--------------------------------------------------------------------------
            */

            $session->update([

                'status' => 'completed',

            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Transaction
            |--------------------------------------------------------------------------
            */

            $transaction = Transaction::create([

                'merchant_id' => $payment->merchant_id,

                'payment_id' => $payment->id,

                'transaction_id' => $payment->transaction_id,

                'provider' => $payment->provider,

                'provider_reference' => $payment->provider_reference,

                'gateway' => $payment->provider,

                'gateway_reference' => $payment->provider_reference,

                'amount' => $payment->amount,

                'currency' => $payment->currency,

                'status' => 'paid',

                'paid_at' => now(),

                'raw_response' => json_encode([
                    'status' => 'APPROVED',
                    'code' => '00',
                    'message' => 'Payment Approved',
                ]),

            ]);

            /*
            |--------------------------------------------------------------------------
            | Response
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'success' => true,

                'message' => 'Payment completed successfully',

                'data' => [

                    'session_id' => $session->session_id,

                    'merchant_id' => $payment->merchant_id,

                    'payment_id' => $payment->id,

                    'payment_method' => $payment->method,

                    'provider' => $payment->provider,

                    'provider_reference' => $payment->provider_reference,

                    'transaction_id' => $transaction->transaction_id,

                    'status' => $payment->status,

                    'amount' => $payment->amount,

                    'currency' => $payment->currency,

                ],

            ]);
        });
    }
}
