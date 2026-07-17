<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Merchant;
use App\Models\Payment;
use App\Models\PaymentIntent;
use Illuminate\Support\Str;

class PaymentIntentService
{
    /**
     * Create a new Payment Intent.
     */
    public function create(
        Merchant $merchant,
        array $data
    ): PaymentIntent {

        $customer = null;

        if (!empty($data['customer_id'])) {

            $customer = Customer::where(
                'merchant_id',
                $merchant->id
            )->findOrFail($data['customer_id']);

        }

        return PaymentIntent::create([

            'intent_id' => 'pi_' . Str::uuid(),

            'merchant_id' => $merchant->id,

            'customer_id' => $customer?->id,

            'amount' => $data['amount'],

            'currency' => $data['currency'] ?? 'DZD',

            'client_secret' => Str::random(64),

            'status' => 'requires_payment_method',

            'metadata' => $data['metadata'] ?? [],

        ]);
    }

    /**
     * Confirm Payment Intent.
     */
    public function confirm(PaymentIntent $intent): Payment
    {
        if ($intent->payment) {
            return $intent->payment;
        }

        $payment = Payment::create([

            'merchant_id' => $intent->merchant_id,

            'customer_id' => $intent->customer_id,

            'payment_id' => 'PDZ_' . strtoupper(Str::random(18)),

            'amount' => $intent->amount,

            'currency' => $intent->currency,

            'status' => 'pending',

            'customer_email' => optional($intent->customer)->email,

            'customer_name' => optional($intent->customer)->name,

        ]);

        $intent->update([

            'payment_id' => $payment->id,

            'status' => 'processing',

            'confirmed_at' => now(),

        ]);

        return $payment;
    }

    /**
     * Cancel Payment Intent.
     */
    public function cancel(PaymentIntent $intent): PaymentIntent
    {
        $intent->update([
            'status' => 'cancelled'
        ]);

        return $intent->refresh();
    }

    /**
     * Get Payment Intent.
     */
    public function find(string $intentId): PaymentIntent
    {
        return PaymentIntent::where(
            'intent_id',
            $intentId
        )->firstOrFail();
    }
}
